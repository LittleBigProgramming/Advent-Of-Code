input = IO.read("input.txt").lines(chomp: true)

def count_trees_from_position(input, position, movement)
  trees = 0

  while position[1] < input.size
    slope = input[position[1]]
    trees += 1 if slope[position[0] % slope.size] == '#'
    position = [position[0] + movement[0], position[1] + movement[1]]
  end

  trees
end

puts [[1,1], [3,1], [5,1], [7,1], [1, 2]].map { |movement|
  x = 0
  y = 0
  position = [x,y]

  count_trees_from_position(input, position, movement)
}.reduce(&:*)
