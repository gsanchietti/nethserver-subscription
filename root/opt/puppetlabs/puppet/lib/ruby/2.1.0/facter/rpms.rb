# rpms.rb

Facter.add('rpms') do
    confine osfamily: 'RedHat'
    setcode do
        tmp = Facter::Core::Execution.exec('rpm -qa --queryformat "%{NAME} %{VERSION}-%{RELEASE}\n"')
        rpms = {}
        tmp.split(/\n/).each do |rpm|
            t = rpm.split(' ')
            rpms[t[0]] = t[1]
        end
        rpms
    end
end
