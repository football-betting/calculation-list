<?php

namespace App;

class CalculationListConfig
{
    const NO_WIN_TEAM = 0;
    const WIN_EXACT = 4;
    const WIN_SCORE_DIFF = 2;
    const WIN_TEAM = 1;

    const TIP_LIST_NAME = 'TipList';
    const MATCH_LIST_NAME = 'MatchList';
    const CALC_LIST_NAME = 'CalculationList';

    const CALC_LIST_EVENT_NAME = 'calculation';
    const MATCH_LIST_EVENT_NAME = 'match';
    const TIP_LIST_EVENT_NAME = 'tip.userlist';
}
