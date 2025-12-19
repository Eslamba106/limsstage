<?php

use App\Models\part_three\ResultTestMethodItem;
use App\Models\SampleTestMethodItem;
use App\Models\second_part\Submission;
use App\Models\Tenant;

if (! function_exists("uploadImage")) {
    function uploadImage($request, $folder_name, $name): mixed
    {
        if (! $request->hasFile($name)) {
            return 0;
        } else {
            $file = $request->file($name);
            $path = $file->store($folder_name, [
                'disk' => 'public',
            ]);
            return $path;
        }
    }
}
if (! function_exists("getAdminPanelUrl")) {
    function getAdminPanelUrl($url = null, $withFirstSlash = true)
    {
        return ($withFirstSlash ? '/' : '') . 'admin' . ($url ?? '');
        // return ($withFirstSlash ? '/' : '') . 'admin' . ($url ?? '');
    }

}

if (! function_exists('clean_html')) {
    function clean_html($text = null)
    {
        if ($text) {
            $text = strip_tags($text, '<h1><h2><h3><h4><h5><h6><p><br><ul><li><hr><a><abbr><address><b><blockquote><center><cite><code><del><i><ins><strong><sub><sup><time><u><img><iframe><link><nav><ol><table><caption><th><tr><td><thead><tbody><tfoot><col><colgroup><div><span>');

            $text = str_replace('javascript:', '', $text);
        }
        return $text;
    }
}

if (! function_exists('clean_html')) {
    function clean_html($text = null)
    {
        if ($text) {
            $text = strip_tags($text, '<h1><h2><h3><h4><h5><h6><p><br><ul><li><hr><a><abbr><address><b><blockquote><center><cite><code><del><i><ins><strong><sub><sup><time><u><img><iframe><link><nav><ol><table><caption><th><tr><td><thead><tbody><tfoot><col><colgroup><div><span>');

            $text = str_replace('javascript:', '', $text);
        }
        return $text;
    }
}
if (! function_exists('selected')) {
    function selected($selected, $current = true, $echo = true)
    {
        return __checked_selected_helper($selected, $current, $echo, 'selected');
    }
}

if (! function_exists('__checked_selected_helper')) {
    function __checked_selected_helper($helper, $current, $echo, $type)
    {
        if ((string) $helper === (string) $current) {
            $result = " $type='$type'";
        } else {
            $result = '';
        }

        if ($echo) {
            echo $result;
        }

        return $result;
    }
}
if (! function_exists('main_path')) {
    function main_path()
    {
        return 'public/';
        // return 'assets/';
    }
}

if (! function_exists('company_id')) {
    function company_id()
    {
        $lastCompany = Tenant::orderBy('id', 'desc')->first();
        if ($lastCompany && $lastCompany->tenant_id) {
            return $lastCompany->tenant_id + 1;
        }
        return 1;
    }
}

if (! function_exists('test_method_result')) {
    function test_method_result($id)
    {
        return ResultTestMethodItem::where('result_test_method_id', $id)->select('result_test_method_id', 'id', 'acceptance_status')->first()->acceptance_status;
    }
}
if (! function_exists('parseLimit')) {
    function parseLimit($limit)
    {
        preg_match('/(<=|>=|=|<|>)(\s*\d+(\.\d+)?)/', $limit, $matches);
        return [
            'operator' => $matches[1] ?? '=',
            'value'    => floatval(trim($matches[2] ?? 0)),
        ];
    }

}
if (! function_exists('evaluateResult')) {
    function evaluateResult($value, $test_method_item_id)
    {
        $test_method_item = SampleTestMethodItem::where('test_method_item_id', $test_method_item_id)->first();

        $actionLimit      = $test_method_item->action_limit;
        $actionLimitType  = $test_method_item->action_limit_type;
        $warningLimit     = $test_method_item->warning_limit;
        $warningLimitType = $test_method_item->warning_limit_type;

        if ($actionLimitType == '=' && $warningLimitType == '=') {
            return action_warning_equal($warningLimit, $actionLimit, $value);
        }

        if ($actionLimitType == '=' && $warningLimitType == '>=') {
            return action_warning_less_than_or_equal($warningLimit, $actionLimit, $value);
        }
        if ($actionLimitType == '=' && $warningLimitType == '<=') {
            return action_warning_more_than_or_equal($warningLimit, $actionLimit, $value);
        }
        if ($actionLimitType == '=' && $warningLimitType == '<') {
            return action_warning_more_than($warningLimit, $actionLimit, $value);
        }
        if ($actionLimitType == '=' && $warningLimitType == '>') {
            return action_warning_less_than($warningLimit, $actionLimit, $value);
        }
        if ($actionLimitType == '<=' && $warningLimitType == '=') {
            return warning_action_more_than_or_equal($warningLimit, $actionLimit, $value);
        }
        if ($actionLimitType == '<=' && $warningLimitType == '<=') {
            return action_warning_less_than_or_equal_and_less_than_or_equal($warningLimit, $actionLimit, $value);
        }

        if ($actionLimitType == '>=' && $warningLimitType == '=') {
            return warning_action_less_than_or_equal($warningLimit, $actionLimit, $value);
        }
        // return "normal";
    }
}

if (! function_exists('get_warning_limit')) {
    function get_warning_limit($test_method_item_id)
    {
        $test_method_item = SampleTestMethodItem::where('test_method_item_id', $test_method_item_id)->first();

        return $test_method_item->warning_limit;
    }

}
if (! function_exists('get_action_limit')) {
    function get_action_limit($test_method_item_id)
    {
        $test_method_item = SampleTestMethodItem::where('test_method_item_id', $test_method_item_id)->first();

        return $test_method_item->action_limit;
    }

}
if (! function_exists('get_warning_limit_and_type')) {
    function get_warning_limit_and_type($test_method_item_id)
    {
        $test_method_item = SampleTestMethodItem::where('test_method_item_id', $test_method_item_id)->first();

        return $test_method_item->warning_limit_type . ' ' . $test_method_item->warning_limit;
    }

}
if (! function_exists('get_action_limit_and_type')) {
    function get_action_limit_and_type($test_method_item_id)
    {
        $test_method_item = SampleTestMethodItem::where('test_method_item_id', $test_method_item_id)->first();

        return $test_method_item->action_limit_type . ' ' . $test_method_item->action_limit;
    }

}
if (! function_exists('get_warning_type')) {
    function get_warning_type($test_method_item_id)
    {
        $test_method_item = SampleTestMethodItem::where('test_method_item_id', $test_method_item_id)->first();

        return $test_method_item->warning_limit_type;
    }

}
if (! function_exists('get_action_type')) {
    function get_action_type($test_method_item_id)
    {
        $test_method_item = SampleTestMethodItem::where('test_method_item_id', $test_method_item_id)->first();

        return $test_method_item->action_limit_type;
    }

}
if (! function_exists('check_coa_settings')) {
    function check_coa_settings($type)
    {

        return true;
        // $coa = COASettings::where('type' , $type)->where('value' , 1)->first();
        // if($coa){

        //     return true;
        // }
        // return false;
    }
}
if (! function_exists('action_warning_equal')) {
    function action_warning_equal($warningLimit, $actionLimit, $value)
    {
        if ($value == $warningLimit) {
            return translate('warning');
        } elseif ($value == $actionLimit) {
            return translate('danger');
        } else {
            return translate('normal');
        }
    }
}
if (! function_exists('warning_action_less_than_or_equal')) {
    function warning_action_less_than_or_equal($warningLimit, $actionLimit, $value)
    {
        if ($value != $warningLimit && $value >= $actionLimit) {
            return translate('danger');
        } elseif ($value == $actionLimit) {
            return translate('warning');
        } else {
            return translate('normal');
        }
    }
}
if (! function_exists('warning_action_more_than_or_equal')) {
    function warning_action_more_than_or_equal($warningLimit, $actionLimit, $value)
    {
        if ($value != $warningLimit && $value <= $actionLimit) {
            return translate('danger');
        } elseif ($value == $actionLimit) {
            return translate('warning');
        } else {
            return translate('normal');
        }
    }
}
if (! function_exists('action_warning_less_than_or_equal')) {
    function action_warning_less_than_or_equal($warningLimit, $actionLimit, $value)
    {
        if ($value >= $warningLimit && $value != $actionLimit) {
            return translate('warning');
        } elseif ($value == $actionLimit) {
            return translate('danger');
        } else {
            return translate('normal');
        }
    }
}
if (! function_exists('action_warning_less_than_or_equal_and_less_than_or_equal')) {
    function action_warning_less_than_or_equal_and_less_than_or_equal($warningLimit, $actionLimit, $value)
    {
        if ($value >= $actionLimit && $value >= $warningLimit) {
            return translate('warning');
        } elseif ($value == $actionLimit) {
            return translate('danger');
        } else {
            return translate('normal');
        }
    }
}
if (! function_exists('action_warning_more_than_or_equal')) {
    function action_warning_more_than_or_equal($warningLimit, $actionLimit, $value)
    {
        if ($value <= $warningLimit && $value != $actionLimit) {
            return translate('warning');
        } elseif ($value == $actionLimit) {
            return translate('danger');
        } else {
            return translate('normal');
        }
    }
}
if (! function_exists('action_warning_more_than')) {
    function action_warning_more_than($warningLimit, $actionLimit, $value)
    {
        if ($value > $warningLimit && $value != $actionLimit) {
            return translate('warning');
        } elseif ($value == $actionLimit) {
            return translate('danger');
        } else {
            return translate('normal');
        }
    }
}
if (! function_exists('case_one')) {
    function case_one($value, $warningLimit, $actionLimit, $warningType, $actionType)
    {
        // warning type >= , action type =
        if ($value >= $warningLimit && $value != $actionLimit) {
            return translate('warning');
        } elseif ($value == $actionLimit) {
            return translate('danger');
        } else {
            return translate('normal');
        }
    }
}
if (! function_exists('action_warning_less_than')) {
    function action_warning_less_than($warningLimit, $actionLimit, $value)
    {
        if ($value < $warningLimit && $value != $actionLimit) {
            return translate('warning');
        } elseif ($value == $actionLimit) {
            return translate('danger');
        } else {
            return translate('normal');
        }
    }
}

if (! function_exists('getFlaskImage')) {
    function getFlaskImage($submission_id)
    {
        $submissionMaster = Submission::find($submission_id);
        $allHaveResults   = $submissionMaster->submission_test_method_items->map(function ($item) {
            return $item->result ? $item->result->status : null;
        });
        $priority = [
            'normal'  => 1,
            'warning' => 2,
            'danger'  => 3,
        ];
        $highest = $allHaveResults
            ->filter()
            ->sortByDesc(fn($status) => $priority[$status] ?? 0)
            ->first();
        if ($highest == 'normal') {
            return 'half_flask_green.png';
        } elseif ($highest == 'warning') {
            return 'half_flask_yellow.png';
        } elseif ($highest == 'danger') {
            return 'half_flask_red.png';
        }
    }

}
if (! function_exists('getFlaskImageFifthStatus')) {
    function getFlaskImageFifthStatus($submission_id)
    {
        $submissionMaster = Submission::find($submission_id);
        $allHaveResults   = $submissionMaster->submission_test_method_items->map(function ($item) {
            return $item->result ? $item->result->status : null;
        });
        $priority = [
            'normal'  => 1,
            'warning' => 2,
            'danger'  => 3,
        ];
        $highest = $allHaveResults
            ->filter()
            ->sortByDesc(fn($status) => $priority[$status] ?? 0)
            ->first();
        if ($highest == 'normal') {
            return 'green_flask.png';
        } elseif ($highest == 'warning') {
            return 'yellow_flask.png';
        } elseif ($highest == 'danger') {
            return 'red_flask.png';
        }
    }

}
if (! function_exists('getStatus')) {
    function getStatus($value, $test_method_item_id)
    {
        $warningLimit = get_warning_limit($test_method_item_id);
        $actionLimit  = get_action_limit($test_method_item_id);
        $actionType   = get_action_type($test_method_item_id);
        $warningType  = get_warning_type($test_method_item_id);
        return getStatusFromLimits($value, $warningLimit, $warningType, $actionLimit, $actionType);

    }
}

/**
 *
 *
 * @param mixed $value
 * @param mixed $warningLimit
 * @param string $warningType
 * @param mixed $actionLimit
 * @param string $actionType
 * @return string
 */
function getStatusFromLimits($value, $warningLimit, $warningType, $actionLimit, $actionType)
{
    if (compare($value, $actionType, $actionLimit)) {
        return 'danger';
    }

    if (compare($value, $warningType, $warningLimit)) {
        return 'warning';
    }

    return 'normal';
}

/**
 *
 *
 * @param mixed $value
 * @param string $operator
 * @param mixed $limit
 * @return bool
 */
function compare($value, $operator, $limit)
{
    switch ($operator) {
        case '>=':
            return $value >= $limit;
        case '<=':
            return $value <= $limit;
        case '>':
            return $value > $limit;
        case '<':
            return $value < $limit;
        case '=':
        case '==':
            return $value == $limit;
        default:
            return false;
    }
}
