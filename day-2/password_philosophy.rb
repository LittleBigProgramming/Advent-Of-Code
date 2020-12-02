input = IO.readlines("input.txt")

def count_valid_passwords(input)
  valid_passwords = input.count do |line|
    policy, password = line.split(': ')
    check_password_for_policy_is_valid?(password, policy)
  end

  return valid_passwords
end

def check_password_for_policy_is_valid?(password, policy)
  policy = parse_policy_rules(policy)

  (password[policy[:position_1] - 1] === policy[:char]) ^ (password[policy[:position_2] - 1] === policy[:char])
end

def parse_policy_rules(policy)
  range, char = policy.split(' ')
  position_1, position_2 = range.split('-').map(&:to_i)

  return { char: char, position_1: position_1, position_2: position_2 }
end

puts count_valid_passwords(input)
