package main

import (
	"fmt"
)

func areClose(m1 map[rune]uint16, m2 map[rune]uint16) bool {

	for k, _ := range m1 {
		if _, ok := m2[k]; !ok {
			return false
		}
	}
	for k, _ := range m2 {
		if _, ok := m1[k]; !ok {
			return false
		}
	}

	for k1, v1 := range m1 {
		for k2, v2 := range m2 {
			if v1 == v2 {
				delete(m1, k1)
				delete(m2, k2)
				break
			}
		}
	}

	if len(m1) > 0 || len(m2) > 0 {
		return false
	}

	return true
}

func closeStrings(word1 string, word2 string) bool {

	var array_count_map1 = make(map[rune]uint16)
	var array_count_map2 = make(map[rune]uint16)
	if len(word1) != len(word2) {
		return false
	}
	for _, value := range word1 {
		array_count_map1[value] += 1
	}
	for _, value := range word2 {
		array_count_map2[value] += 1
	}

	return areClose(array_count_map1, array_count_map2)
}

func main() {
	fmt.Println(closeStrings("abc", "bca"))
}
