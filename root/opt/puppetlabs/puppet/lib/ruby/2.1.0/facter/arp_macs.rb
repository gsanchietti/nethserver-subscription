Facter.add('arp_macs') do
    confine osfamily: 'RedHat'
    setcode do
        tmp = Facter::Core::Execution.exec('arp -an | grep -v incomplete | wc -l')
        arp_macs = tmp
        arp_macs
    end
end