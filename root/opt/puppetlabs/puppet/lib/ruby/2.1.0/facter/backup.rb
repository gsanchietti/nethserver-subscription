# backup.rb

Facter.add('backup') do
    confine osfamily: 'RedHat'
    setcode do
        backup = {}
        backup_status = Facter::Core::Execution.exec('/sbin/e-smith/config getprop backup-data status')
        if backup_status == 'enabled'
            log_file = Facter::Core::Execution.exec('/sbin/e-smith/config getprop backup-data LogFile')
            if FileTest.exists?(log_file)
                backup['last'] = {}
                backup['last']['type'] = Facter::Core::Execution.exec('/sbin/e-smith/config getprop backup-data VFSType')
                File.open(log_file, 'rb') do |f|
                    while line = f.gets
                        backup['last']['start'] = Regexp.last_match(1) if line =~ /^StartTime\s(\d+)/
                        backup['last']['end'] = Regexp.last_match(1) if line =~ /^EndTime\s(\d+)/
                        backup['last']['ret_code'] = Regexp.last_match(1) if line =~ /^Errors\s(\d+)/
                    end
                end
            end
        end
        backup
    end
end
