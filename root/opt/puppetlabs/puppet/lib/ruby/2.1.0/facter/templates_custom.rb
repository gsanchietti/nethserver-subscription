#
# templates_custom
# Count the number of files under templates-custom
#

Facter.add('templates_custom') do
    confine osfamily: 'RedHat'
    setcode do
        out = Facter::Core::Execution.exec('find /etc/e-smith/templates-custom -type f -printf "%h\n" | sed s:^/etc/e-smith/templates-custom:: | sort | uniq')
        out.strip.split(/\n/)
    end
end
