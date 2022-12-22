<?php
class Solution {
    public function spliceImgZero ($img) {
        $bottom = count($img) - 1;

        $k = -1;

        for ($i=0; $i <= $bottom; $i++) {
            if(array_sum($img[$i]) == 0) {
                $k++;
            } else {
                break;
            }
        }

        for ($i = 0; $i <= $k; $i++) {
            array_splice($img, 0, 1);
        }

        $bottom = count($img) - 1;
        $k = $bottom + 1;

        /*if ($bottom == 0) {
            return $img;
        }*/

        for ($i=$bottom; $i >= 0; $i--){
            if(array_sum($img[$i]) == 0) {
                $k--;
            } else {
                break;
            }
        }

        for ($i = $bottom; $i >= $k; $i--) {
            array_splice($img, -1, 1);
        }

        $bottom = count($img) - 1;
        if ($bottom < 0) {
            return [];
        }
        $right = count($img[0]) - 1;
        $k = -1;

        /*if ($bottom == 0) {
            return $img;
        }*/

        for ($j = 0; $j <= $right; $j++) {
            if(array_sum(array_column($img,$j)) == 0) {
                $k++;
            } else {
                break;
            }
        }

        for ($i = 0; $i <= $bottom; $i++) {
            for ($j = 0; $j <= $k; $j++) {
                array_splice($img[$i], 0, 1);
            }
        }

        $bottom = count($img) - 1;
        if ($bottom < 0) {
            return [];
        }
        $right = count($img[0]) - 1;
        $k = $right + 1;

        for ($j = $right; $j >= 0; $j--) {
            if(array_sum(array_column($img,$j)) == 0) {
                $k--;
            } else {
                break;
            }
        }

        for ($i = 0; $i <= $bottom; $i++) {
            for ($j = $right; $j >= $k; $j--) {
                array_splice($img[$i], -1, 1);
            }
        }

        return $img;
    }

    public function countOverlap($baseImg, $windowImg, $x, $y) : int{

        $resultSum = 0;
        foreach ($windowImg as $i=>$row) {
            foreach ($row as $j=>$value) {
                if (isset($baseImg[$x+$i])
                    && isset($baseImg[$x+$i][$y+$j])
                    && $value == 1
                    && $baseImg[$x+$i][$y+$j] == $value) {
                    $resultSum++;
                }
            }
        }
        return $resultSum;
    }

    public function specialReindexImage($img) : array {
        $bottomImg = count($img) - 1;
        $rightImg = count($img[0]) - 1;
        $resultImg = [];
        for ( $i = 0; $i <= $bottomImg; $i++) {
            for ($j = 0; $j <= $rightImg; $j++) {
                $resultImg[$i - $bottomImg][$j - $rightImg] = $img[$i][$j];
            }
        }
        return $resultImg;
    }

    private const BITS = [
        0, 1, 1, 2, 1, 2, 2, 3, 1, 2, 2, 3, 2, 3, 3, 4, 1, 2, 2, 3, 2, 3, 3, 4, 2, 3, 3, 4, 3, 4, 4, 5,
        1, 2, 2, 3, 2, 3, 3, 4, 2, 3, 3, 4, 3, 4, 4, 5, 2, 3, 3, 4, 3, 4, 4, 5, 3, 4, 4, 5, 4, 5, 5, 6,
        1, 2, 2, 3, 2, 3, 3, 4, 2, 3, 3, 4, 3, 4, 4, 5, 2, 3, 3, 4, 3, 4, 4, 5, 3, 4, 4, 5, 4, 5, 5, 6,
        2, 3, 3, 4, 3, 4, 4, 5, 3, 4, 4, 5, 4, 5, 5, 6, 3, 4, 4, 5, 4, 5, 5, 6, 4, 5, 5, 6, 5, 6, 6, 7,
        1, 2, 2, 3, 2, 3, 3, 4, 2, 3, 3, 4, 3, 4, 4, 5, 2, 3, 3, 4, 3, 4, 4, 5, 3, 4, 4, 5, 4, 5, 5, 6,
        2, 3, 3, 4, 3, 4, 4, 5, 3, 4, 4, 5, 4, 5, 5, 6, 3, 4, 4, 5, 4, 5, 5, 6, 4, 5, 5, 6, 5, 6, 6, 7,
        2, 3, 3, 4, 3, 4, 4, 5, 3, 4, 4, 5, 4, 5, 5, 6, 3, 4, 4, 5, 4, 5, 5, 6, 4, 5, 5, 6, 5, 6, 6, 7,
        3, 4, 4, 5, 4, 5, 5, 6, 4, 5, 5, 6, 5, 6, 6, 7, 4, 5, 5, 6, 5, 6, 6, 7, 5, 6, 6, 7, 6, 7, 7, 8
    ];

    private static function countBits($v) {
        return Solution::BITS[$v >> 24] + Solution::BITS[($v >> 16) & 0xFF] + Solution::BITS[($v >> 8) & 0xFF] + Solution::BITS[$v & 0xFF];
    }

    /**
     * @param Integer[][] $img1
     * @param Integer[][] $img2
     * @return Integer
     */
    function fastLargestOverlap($img1, $img2) {
        $n = count($img1);
        $A = [];
        $B = [];
        for ($i = 0; $i < $n; ++$i) {
            $bits = 0;
            for ($j = 0; $j < $n; ++$j)
                $bits = ($bits << 1) | $img1[$i][$j];
            $A[] = $bits;
            $bits = 0;
            for ($j = 0; $j < $n; ++$j)
                $bits = ($bits << 1) | $img2[$i][$j];
            $B[] = $bits;
        }
        $r = 0;
        for ($i = 0; $i < $n; ++$i)
            for ($j = 0; $j < $n; ++$j) {
                $r0 = 0;
                for ($a = 0, $b = $i; $b < $n; ++$a, ++$b)
                    $r0 += Solution::countBits(($A[$a] >> $j) & $B[$b]);
                if ($r0 > $r)
                    $r = $r0;
                $r0 = 0;
                for ($a = 0, $b = $i; $b < $n; ++$a, ++$b)
                    $r0 += Solution::countBits(($A[$b] >> $j) & $B[$a]);
                if ($r0 > $r)
                    $r = $r0;
                $r0 = 0;
                for ($a = 0, $b = $i; $b < $n; ++$a, ++$b)
                    $r0 += Solution::countBits($A[$a] & ($B[$b] >> $j));
                if ($r0 > $r)
                    $r = $r0;
                $r0 = 0;
                for ($a = 0, $b = $i; $b < $n; ++$a, ++$b)
                    $r0 += Solution::countBits($A[$b] & ($B[$a] >> $j));
                if ($r0 > $r)
                    $r = $r0;
            }
        return $r;
    }
    /**
     * @param Integer[][] $img1
     * @param Integer[][] $img2
     * @return Integer
     */
    public function largestOverlap(array $img1, array $img2) : int {
        $imageSpliced1 = $this->spliceImgZero($img1);
        $imageSpliced2 = $this->spliceImgZero($img2);

        $bottomImg1 = count($imageSpliced1) - 1;
        if ($bottomImg1 < 0) {
            return 0;
        }
        $rightImg1 = count($imageSpliced1[0]) - 1;

        $bottomImg2 = count($imageSpliced2) - 1;
        if ($bottomImg2 < 0) {
            return 0;
        }
        $rightImg2 = count($imageSpliced2[0]) - 1;

        $max = 0;

        if ($bottomImg1*$rightImg1 > $bottomImg2*$rightImg2) {
            $specialReindexImage = $this->specialReindexImage($imageSpliced2);
            for ($i = 0; $i <= $bottomImg2 + $bottomImg1; $i++) {
                for ($j = 0; $j <= $rightImg2 + $rightImg1; $j++) {
                    $tempResult = $this->countOverlap($imageSpliced1, $specialReindexImage,$i,$j);
                    if($tempResult > $max) {
                        $max = $tempResult;
                    }
                }
            }
        }else{
            $specialReindexImage = $this->specialReindexImage($imageSpliced1);
            for ($i = 0; $i <= $bottomImg2 + $bottomImg1; $i++) {
                for ($j = 0; $j <= $rightImg2 + $rightImg1; $j++) {
                    $tempResult = $this->countOverlap($imageSpliced2, $specialReindexImage,$i,$j);
                    if($tempResult > $max) {
                        $max = $tempResult;
                    }
                }
            }
        }

        #print_r($imageSpliced2);
        #print_r($this->specialReindexImage($imageSpliced2));

        return $max;


    }
}

$myTest =  new Solution();
$t = $myTest->largestOverlap([[1,1,0,1,0,1,0,0,0,0],[0,1,1,1,0,0,0,0,0,0],[0,1,0,0,1,0,0,1,0,0],[0,1,0,0,0,0,0,1,0,0],[0,0,1,0,1,0,0,0,0,0],[0,1,1,0,0,0,1,0,0,0],[0,1,0,1,1,0,0,1,0,1],[1,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,1,0,1,0],[1,0,0,1,1,1,0,0,1,0]],
    [[1,1,1,1,1,0,1,1,1,1],[1,1,1,1,0,1,1,1,0,0],[1,1,1,1,0,1,1,0,1,1],[1,0,1,1,0,0,1,0,1,1],[1,1,0,1,1,1,0,0,1,1],[1,1,1,1,1,0,0,1,0,1],[0,1,1,1,1,1,1,0,1,1],[0,1,1,1,0,1,1,1,1,1],[1,0,1,1,1,1,1,1,0,0],[1,1,1,1,1,1,1,1,1,0]]);
print_r($t);

$t = $myTest->fastLargestOverlap([[1,1,0,1,0,1,0,0,0,0],[0,1,1,1,0,0,0,0,0,0],[0,1,0,0,1,0,0,1,0,0],[0,1,0,0,0,0,0,1,0,0],[0,0,1,0,1,0,0,0,0,0],[0,1,1,0,0,0,1,0,0,0],[0,1,0,1,1,0,0,1,0,1],[1,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,1,0,1,0],[1,0,0,1,1,1,0,0,1,0]],
    [[1,1,1,1,1,0,1,1,1,1],[1,1,1,1,0,1,1,1,0,0],[1,1,1,1,0,1,1,0,1,1],[1,0,1,1,0,0,1,0,1,1],[1,1,0,1,1,1,0,0,1,1],[1,1,1,1,1,0,0,1,0,1],[0,1,1,1,1,1,1,0,1,1],[0,1,1,1,0,1,1,1,1,1],[1,0,1,1,1,1,1,1,0,0],[1,1,1,1,1,1,1,1,1,0]]);
print_r($t);
#print_r($imageSpliced1);
#print_r($imageSpliced1);
/*
$t = $myTest->largestOverlap([[0,0,0,0,1],[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0]],
    [[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0],[1,0,0,0,0]]);
print_r($t);
#print_r( largestOverlap([[1,1,0],[0,1,0],[0,1,0]],[[0,0,0],[0,1,1],[0,0,1]]));
$t = $myTest->largestOverlap([[1,1,0],[0,1,0],[0,1,0]],[[0,0,0],[0,1,1],[0,0,1]]);
print_r($t);
#print_r( largestOverlap([[1]],[[1]]));
$t = $myTest->largestOverlap([[1]],[[1]]);
print_r($t);
#print_r( largestOverlap([[0]],[[0]]));
$t = $myTest->largestOverlap([[0]],[[0]]);
print_r($t);
#print_r( largestOverlap([[0,0,0],[1,1,0],[0,0,0]],[[0,1,1],[0,0,0],[0,0,0]]));
$t = $myTest->largestOverlap([[0,0,0],[1,1,0],[0,0,0]],[[0,1,1],[0,0,0],[0,0,0]]);
print_r($t);
#print_r( largestOverlap([[1,0],[0,0]], [[0,1],[1,0]]));
$t = $myTest->largestOverlap([[1,0],[0,0]], [[0,1],[1,0]]);
print_r($t);
#print_r( largestOverlap([[0,0,0],[1,0,0],[1,0,0]], [[1,0,0],[1,1,1],[0,0,1]]));
$t = $myTest->largestOverlap([[0,0,0],[1,0,0],[1,0,0]], [[1,0,0],[1,1,1],[0,0,1]]);
print_r($t);

#array_count_values([[1,1,0],[0,1,0],[0,1,0]]);
*/