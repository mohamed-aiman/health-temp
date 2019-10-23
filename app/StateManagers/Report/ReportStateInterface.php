<?php
namespace App\StateManagers\Report;

interface ReportStateInterface
{
	public function generated(); //inspection level
	public function prepared(); //inspection level
	public function approved(); //supervisory level
	public function handedOver(); //inspection level
}
