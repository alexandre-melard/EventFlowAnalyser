#
# Cookbook Name:: JQueryFileUploadSandbox
# Recipe:: default
#
# Copyright 2012, Mylen
#
# All rights reserved - Do Not Redistribute
#
# Platform-specific configuration
case node["platform"]
when "centos", "redhat", "fedora"
  include_recipe "rpmforge"
  include_recipe "selinux::disabled"
when "debian", "ubuntu"
  # make sure apt package cache is up-to-date
  execute "apt-get-update" do
    command "apt-get update"
  end
  
  # set up apt
  include_recipe "apt"
end

# install the software we need
package "openjdk-6-jre-headless"
package "curl"
package "tmux"
package "vim"
package "emacs23-nox"
package "git"
package "tree"
package "libapache2-mod-php5"
package "php5-cli"
package "php5-curl"
package "php5-mysql"
package "php5-intl"
package "php-apc"
package "php5-xdebug"

template "/etc/apache2/sites-enabled/vhost.conf" do
  user "root"
  mode "0644"
  source "vhost.conf.erb"
  notifies :reload, "service[apache2]"
end

service "apache2" do
  supports :restart => true, :reload => true, :status => true
  action [ :enable, :start ]
end

execute "check if short_open_tag is Off in /etc/php5/apache2/php.ini?" do
  user "root"
  not_if "grep 'short_open_tag = Off' /etc/php5/apache2/php.ini"
  command "sed -i 's/short_open_tag = On/short_open_tag = Off/g' /etc/php5/apache2/php.ini"
end

execute "check if short_open_tag is Off in /etc/php5/cli/php.ini?" do
  user "root"
  not_if "grep 'short_open_tag = Off' /etc/php5/cli/php.ini"
  command "sed -i 's/short_open_tag = On/short_open_tag = Off/g' /etc/php5/cli/php.ini"
end

execute "check if date.timezone is Europe/Paris in /etc/php5/apache2/php.ini?" do
  user "root"
  not_if "grep '^date.timezone = Europe/Paris' /etc/php5/apache2/php.ini"
  command "sed -i 's/;date.timezone =.*/date.timezone = Europe\\/Paris/g' /etc/php5/apache2/php.ini"
end

execute "check if date.timezone is Europe/Paris in /etc/php5/cli/php.ini?" do
  user "root"
  not_if "grep '^date.timezone = Europe/Paris' /etc/php5/cli/php.ini"
  command "sed -i 's/;date.timezone =.*/date.timezone = Europe\\/Paris/g' /etc/php5/cli/php.ini"
end

package 'php5-xdebug' do
  notifies :create, "ruby_block[provision_xdebug]", :immediately
end

ruby_block "provision_xdebug" do
  block do
    file = Chef::Util::FileEdit.new("/etc/php5/apache2/php.ini")
    file.insert_line_if_no_match("/[xdebug]/", "[xdebug]")
    file.write_file
    file.insert_line_if_no_match("/xdebug.default_enable=1/", "xdebug.default_enable=1")
    file.write_file
    file.insert_line_if_no_match("/xdebug.remote_enable=1/", "xdebug.remote_enable=1")
    file.write_file
    file.insert_line_if_no_match("/xdebug.remote_handler=dbgp/", "xdebug.remote_handler=dbgp")
    file.write_file
    file.insert_line_if_no_match("/xdebug.remote_host=192.168.111.1/", "xdebug.remote_host=192.168.111.1")
    file.write_file
    file.insert_line_if_no_match("/xdebug.remote_port=9000/", "xdebug.remote_port=9000")
    file.write_file
    file.insert_line_if_no_match("/xdebug.remote_autostart=1/", "xdebug.remote_autostart=1")
    file.write_file
    file.insert_line_if_no_match("/xdebug.max_nesting_level=200/", "xdebug.max_nesting_level=200")
    file.write_file
  end
end
  

