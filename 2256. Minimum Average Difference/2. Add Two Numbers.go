package main

import (
	"fmt"
)

/**
 * Definition for singly-linked list.
 * type ListNode struct {
 *     Val int
 *     Next *ListNode
 * }
 */

type ListNode struct {
	Val  int
	Next *ListNode
}

func addTwoNumbers(l1 *ListNode, l2 *ListNode) *ListNode {
	currentL1, currentL2 := l1, l2
	currentValL1, currentValL2, resultVal := 0, 0, 0
	rank := 0

	for currentL1 != nil || currentL2 != nil {
		if currentL1 != nil {
			currentValL1 = currentL1.Val
		} else {
			currentValL1 = 0
		}
		if currentL2 != nil {
			currentValL2 = currentL2.Val
		} else {
			currentValL2 = 0
		}
		if currentValL1+currentValL2+rank > 9 {
			resultVal = currentValL1 + currentValL2 + rank - 10
			rank = 1
		} else {
			resultVal = currentValL1 + currentValL2 + rank
			rank = 0
		}

		if currentL1 != nil {
			currentL1.Val = resultVal
			if currentL1.Next == nil && currentL2 != nil && currentL2.Next != nil {
				currentL1.Next = &ListNode{Val: 0, Next: nil}
			}
		}

		if currentL1 != nil {
			if currentL1.Next == nil && rank > 0 {
				currentL1.Next = &ListNode{Val: 1, Next: nil}
				rank = 0
			}
			currentL1 = currentL1.Next
		}
		if currentL2 != nil {
			if currentL2.Next == nil && rank > 0 {
				currentL2.Next = &ListNode{Val: 1, Next: nil}
				rank = 0
			}
			currentL2 = currentL2.Next
		}
	}

	return l1
}

func main() {

	l1 := &ListNode{Val: 2, Next: &ListNode{Val: 4, Next: &ListNode{Val: 9, Next: nil}}}
	l2 := &ListNode{Val: 5, Next: &ListNode{Val: 6, Next: &ListNode{Val: 4, Next: &ListNode{Val: 9, Next: nil}}}}
	fmt.Println(addTwoNumbers(l1, l2))
}
