package main

import (
	"fmt"
)

func hasPossible(m map[rune]uint16) bool {
	max, min := uint16(0), uint16(1000)
	flag_max := 0
	flag_min := 1000

	frequencyMap := make(map[uint16]uint16)

	for _, v := range m {
		frequencyMap[v] += 1
	}

	if len(frequencyMap) > 2 {
		return false
	}

	for k, v := range frequencyMap {
		if max < v {
			max = v
		}
		if flag_max < int(k) {
			flag_max = int(k)
		}
		if min > v {
			min = v
		}
		if flag_min > int(k) {
			flag_min = int(k)
		}
	}

	if len(frequencyMap) == 1 && min == max && flag_min == 1 {
		return true
	}

	if len(frequencyMap) == 1 && min == max && min == 1 {
		return true
	}

	if flag_max-flag_min == 1 && frequencyMap[uint16(flag_max)] == 1 {
		return true
	}
	if flag_min == 1 && frequencyMap[uint16(flag_min)] == 1 {
		return true
	}

	return false
}

func equalFrequency(word string) bool {

	var array_count_map = make(map[rune]uint16)
	for _, value := range word {
		array_count_map[value] += 1
	}

	return hasPossible(array_count_map)
}

func main() {
	fmt.Println(equalFrequency("zz"))
}
