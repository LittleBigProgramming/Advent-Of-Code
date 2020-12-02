input = IO.readlines("input.txt")

def count_valid_passwords(input)
  valid_passwords = input.count do |line|
    policy, password = line.split(': ')
    check_password_for_policy_is_valid(password, policy)
  end

  return valid_passwords
end

def check_password_for_policy_is_valid?(password, policy)
  policy = parse_policy_rules(policy)
  password.count(policy[:char]).between?(policy[:min_char_count], policy[:max_char_count])
end

def parse_policy_rules(policy)
  range, char = policy.split(' ')
  min, max = range.split('-').map(&:to_i)

  return { char: char, min_char_count: min, max_char_count: max }
end

puts count_valid_passwords(input)
