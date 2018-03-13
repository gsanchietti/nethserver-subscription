# users.rb

require 'json'

Facter.add('users') do
    setcode do
        users = []
        tmp = Facter::Core::Execution.exec('/usr/libexec/nethserver/list-users')
        begin
            users_info = JSON.parse(tmp)
            users_info.each do |user, props|
                users.push({ :username => user, :name => props["gecos"] })
            end

        rescue JSON::ParserError => e
            users = []
        end
        users
    end
end
