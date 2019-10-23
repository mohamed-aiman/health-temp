<?php

namespace App\Helpers;

use App\NormalForm;

class GradingCalculator
{
	public static function calculate(NormalForm $gradingForm)
	{
		$totalPointsCount = \DB::select("
			select code, count(code) as count from normal_form_points  where normal_form_id = {$gradingForm->id} group by code
		");

		$total = [];
		foreach ($totalPointsCount as $lc) {
			$total[trim($lc->code)] = $lc->count;
		}

		$notSatisfiedPointsCount = \DB::select("
			select code, count(code) as count from normal_form_points  where normal_form_id = {$gradingForm->id}  and value = 0 and not_applicable = 0 group by code
		");
		

		$notSatisfied = [];
		foreach ($notSatisfiedPointsCount as $lc) {
			$notSatisfied[trim($lc->code)] = $lc->count;
		}

		$satisfiedPointsCount = \DB::select("
			select code, count(code) as count from normal_form_points  where normal_form_id = {$gradingForm->id}  and value = 1 and not_applicable = 0 group by code
		");

		$satisfied = [];
		foreach ($satisfiedPointsCount as $lc) {
			$satisfied[trim($lc->code)] = $lc->count;
		}


		$notApplicablePointsCount = \DB::select("
			select code, count(code) as count from normal_form_points  where normal_form_id = {$gradingForm->id}  and not_applicable = 1 group by code
		");

		$notApplicable = [];
		foreach ($notApplicablePointsCount as $lc) {
			$notApplicable[trim($lc->code)] = $lc->count;
		}

		$grades = [
			'A' => [
				'CR' => 0, //or
				'MJ' => 15, //15< or
				'MN' => 10, //10< 
			],
			'B' => [
				'CR' => 0, //or
				'MJ' => 20, //20< or
				'MN' => 20, //20< 
			],
			'C' => [
				'CR' => 0, //or
				'MJ' => 25, //25< or
				'MN' => 30, //30< 
			],
		];

		if (!isset($notSatisfied['CR'])) {
			$notSatisfied['CR'] = 0;
		}
		if (!isset($notSatisfied['MJ'])) {
			$notSatisfied['MJ'] = 0;
		}
		if (!isset($notSatisfied['MN'])) {
			$notSatisfied['MN'] = 0;
		}

		if (($notSatisfied['CR'] <= $grades['A']['CR']) && ($notSatisfied['MJ'] <= $grades['A']['MJ']) && ($notSatisfied['MN'] <= $grades['A']['MN'])) {
			$grade = 'A';
		} else if (($notSatisfied['CR'] <= $grades['B']['CR']) && ($notSatisfied['MJ'] <= $grades['B']['MJ']) && ($notSatisfied['MN'] <= $grades['B']['MN'])) {
			$grade = 'B';
		} else if (($notSatisfied['CR'] <= $grades['C']['CR']) && ($notSatisfied['MJ'] <= $grades['C']['MJ']) && ($notSatisfied['MN'] <= $grades['C']['MN'])) {
			$grade = 'C';
		} else {
			$grade = 'FAIL';
		}


		return [
			'counts' => [
				'total' => $total,
				'satisfied' => $satisfied,
				'not_satisfied' => $notSatisfied,
				'not_applicable' => $notApplicable,
			],
			'grade' => $grade
		];

	}
}