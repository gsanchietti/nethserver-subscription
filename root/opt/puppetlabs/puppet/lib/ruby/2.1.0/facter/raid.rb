# raid.rb

Facter.add('raid') do
    confine kernel: :linux
    setcode do
        devices = {}
        if FileTest.exists?('/proc/mdstat')
            File.open('/proc/mdstat', 'r') do |f|
                while line = f.gets
                    if line =~ /^(md)/
                        t = line.split(/\[\d\]\(\w\)\s|\[\d+\]\s|\W+/)
                        dev = t[0]
                        devices[dev] = {}
                        devices[dev]['status'] = t[1]
                        devices[dev]['type'] = t[2]
                        devices[dev]['disks'] = t[3, t.length - 1]
                      end
                    devices[dev]['alignment'] = Regexp.last_match(1) if line =~ /\[([_U]+)\]/
                end
            end
        end
        devices
    end
end
