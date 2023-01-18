<?php

namespace App;

use App\Http\Controllers\Functions\FunctionController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Morilog\Jalali\CalendarUtils;
use function PHPUnit\Framework\fileExists;

class Cargo extends Model
{
    protected $with = ['menus'];
    protected $guarded = [];

    static public function getByParent($parent_id, $filter)
    {

        if (Menu::find($parent_id)->parent_id == 0) {
            $cargos = Cargo::whereHas('menus', function ($query) use ($parent_id) {
                $query->where('pivot_parent_id', $parent_id);
            })->sellableCargos()->get();

        } else {
            $cargos = Cargo::whereHas('menus', function ($query) use ($parent_id) {
                $query->where('menu_id', $parent_id);
            })->sellableCargos()->get();

        }

        if (!empty($filter)) {
            switch ($filter) {
                case(1):
                    //search by max amount
                    $cargos = $cargos->sortBy('price_discount');
                    break;

                case(2):
                    //search by min amount
                    $cargos = $cargos->sortByDesc('price_discount');
                    break;

                default:
                    $cargos = $cargos->sortBy('name');
            }
        } else {
            $cargos = $cargos->sortBy('name');
        }

        $not_finished_cargos = $cargos->filter(function ($item) {
            return $item->max_count > 0;
        });

        $finished_cargos = $cargos->filter(function ($item) {
            return $item->max_count == 0;
        });

        return $not_finished_cargos->merge($finished_cargos);
    }

    public function scopeSellableCargos($query)
    {
        return $query->where('price_discount', '>', 1)->where('price', '>', 1)->where('status', '=', '1');
    }

//        admin search
    public function scopeSearchAdmin($query, $keywords)
    {
        $query
            ->where('market_id', 1)
            ->where('id', 'LIKE', '%' . $keywords['search_by_id'] . '%')
            ->where('price', 'LIKE', $keywords['search_by_price'] . '%')
            ->where('price_discount', 'LIKE', $keywords['search_by_price_discount'] . '%')
            ->where('max_count', 'LIKE', $keywords['search_by_max_count'])
            ->where('buy_count', 'LIKE', $keywords['search_by_buy_count'] . '%')
            ->where('vote_average', 'LIKE', $keywords['search_by_vote_average'] . '%')
            ->where('vote_count', 'LIKE', $keywords['search_by_vote_count'] . '%')
            ->where('max_order', 'LIKE', $keywords['search_by_max_order'] . '%')
            ->where('status', 'LIKE', $keywords['search_by_status'])
            ->where('newest', 'LIKE', $keywords['search_by_newest'])
            ->where('mfg_date_show', 'LIKE', $keywords['search_by_mfg_date_show'])
            ->where('exp_date_show', 'LIKE', $keywords['search_by_exp_date_show']);
        return $query;
    }

    //home search
    public function scopeSearch($query, $keywords)
    {
        $query
            ->where('market_id', 1)
            ->where('id', 'LIKE', '%' . $keywords['search_by_id'] . '%')
            ->where('name', 'LIKE', '%' . $keywords['search_by_name'] . '%')
            ->where('price', 'LIKE', $keywords['search_by_price'])
            ->where('max_count', 'LIKE', $keywords['search_by_max_count'])
            ->where('max_order', 'LIKE', $keywords['search_by_max_order']);
        return $query;
    }

    static public function getByName($text_search)
    {
        $cargos = Cargo::where('name', 'like', "%$text_search%")
            ->sellableCargos();
        $not_finished_cargos = clone $cargos;
        $finished_cargos = clone $cargos;
        $not_finished_cargos = $not_finished_cargos->where('max_count', '>', "0")->get();
        $not_finished_cargos = $not_finished_cargos->sortBy('name');
        $finished_cargos = $finished_cargos->where('max_count', '=', '0')->get();
        $finished_cargos = $finished_cargos->sortBy('name');
        return $not_finished_cargos->concat($finished_cargos);
    }


    public static function getCargo($id)
    {
        return self::where('id', $id)
            ->where('status', "1")
            ->where('price', '!=', 0)
            ->where('price_discount', '!=', 0)
            ->first();
    }

    public function is_amazing()
    {
        $cargo = Amazing::where('cargo_id', $this->id)->first();
        if ($cargo and $cargo->status == '1' and $cargo->start_at < Carbon::now() and $cargo->end_at > Carbon::now()) {
            return 1;
        }
        return 0;
    }

    public function getMainPriceMethodAttribute()
    {
        $cargo = Amazing::where('cargo_id', $this->id)->first();
        if ($cargo and $cargo->status == '1' and $cargo->start_at < Carbon::now() and $cargo->end_at > Carbon::now()) {
            return (int)Amazing::where('cargo_id', $this->id)->first()->price_discount;
        }
        return (int)$this->price_discount;
    }

    public static function getLogo($id)
    {
        $cargo = Cargo::findOrFail($id);
//        $stamp = imagecreatefrompng('images/waterMark/logo.png');
//        if (file_exists("images/imagefood/qazvin/$id.jpg"))
//            $im = imagecreatefromjpeg("images/imagefood/qazvin/$id.jpg");
//        else
//            $im = imagecreatefromjpeg("images/imagefood/qazvin/noimage.jpg");
//        // $im = imagecreatefromjpeg("images/imagefood/$host->folder_name/$id.jpg");
//        $marge_right = 10;
//        $marge_bottom = 10;
//        $sx = imagesx($stamp);
//        $sy = imagesy($stamp);
//        imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
//        header('Content-type: image/jpeg');
//        $watermarked_path = "images/cargos/qazvin/$id.jpg";
//        imagejpeg($im, $watermarked_path, 80);
//        imagedestroy($im);
//        return env('APP_URL').'/'.$watermarked_path;


        $stamp = imagescale(imagecreatefrompng('images/waterMark/logo.png'), 38, 38);
        if (file_exists("images/imagefood/qazvin/$id.jpg"))
            $im = imagecreatefromjpeg("images/imagefood/qazvin/$id.jpg");
        else
            $im = imagecreatefromjpeg("images/imagefood/qazvin/noimage.jpg");
        // $im = imagecreatefromjpeg("images/imagefood/$host->folder_name/$id.jpg");
        $marge_right = 10;
        $marge_bottom = 10;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);
        imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
        header('Content-type: image/jpeg');
        $watermarked_path = "images/cargos/qazvin/$id.jpg";
//        if (fileExists($watermarked_path)){
//            unlink($watermarked_path);
//        }

        imagejpeg($im, $watermarked_path, 80);
        imagedestroy($im);
        return env('APP_URL') . '/' . $watermarked_path . '?v=' . $cargo->image_version;

    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class)->withPivot('order', 'pivot_parent_id');
    }

}
