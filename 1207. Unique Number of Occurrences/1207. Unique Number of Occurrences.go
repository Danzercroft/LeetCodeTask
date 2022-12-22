package main

import (
	"fmt"
	"sort"
)

func hasDupes(m map[int16]uint16) bool {
	x := make(map[uint16]struct{})

	for _, v := range m {
		if _, has := x[v]; has {
			return true
		}
		x[v] = struct{}{}
	}

	return false
}

func uniqueOccurrences(arr []int) bool {
	sort.Ints(arr)
	var array_count_map = make(map[int16]uint16)
	for _, value := range arr {
		array_count_map[int16(value)] += 1
	}

	return !hasDupes(array_count_map)
}

func main() {
	var n = []int{1, 2, 2, 1, 1, 3}

	fmt.Println(uniqueOccurrences(n))
}
