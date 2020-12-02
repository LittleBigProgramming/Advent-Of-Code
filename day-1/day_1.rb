expenses = IO.readlines("input.txt").map(&:to_i)

puts expenses.combination(2).find { |expense| expense.sum === 2020 }.reduce(:*)
puts expenses.combination(3).find { |expense| expense.sum === 2020 }.reduce(:*)
