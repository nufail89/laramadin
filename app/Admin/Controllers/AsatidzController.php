<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Asatidz;
use \App\Models\TUsrPerson;
use SebastianBergmann\Type\FalseType;

class AsatidzController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Asatidz';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $user = \Auth::user();
        $lembaga_id = TUsrPerson::where('user_id', $user->id)->pluck('lembaga_id')->first();
        $grid = new Grid(new TUsrPerson());
        $grid->model()->where('lembaga_id', $lembaga_id);
        $grid->column('asatidz.nama', __('Nama'));
        $grid->column('asatidz.nickname', __('Nickname'));
        $grid->column('asatidz.no_hp', __('No hp'));
        $grid->column('asatidz.gender', __('J.Kelamin'));
        $grid->column('asatidz.alamat', __('Alamat'))->hide();
        $grid->column('asatidz.tempat_lahir', __('Tempat lahir'))->hide();
        $grid->column('asatidz.tanggal_lahir', __('Tanggal lahir'))->hide();
        $grid->column('jabatan.jabatan', __('Jabatan'))->filter('like');
        $grid->column('asatidz.TMT', __('TMT'))->hide();
        $grid->column('asatidz.gelar_depan', __('Gelar depan'))->hide();
        $grid->column('asatidz.gelar_belakang', __('Gelar belakang'))->hide();
        $grid->column('asatidz.status_kawin', __('Status kawin'))->hide();
        $grid->column('asatidz.no_sk', __('No sk'))->hide();
        $grid->column('asatidz.foto_url', __('Foto url'))->hide();
        $grid->column('asatidz.rek_kjks', __('Rek kjks'))->hide();
        $grid->column('isActive', __('Status Aktif'))->display(function ($isActive) {
            return $isActive ? 'Aktif' : 'Non Aktif';
        })->hide();
        if(!$user->can('guru.manage')){
            $grid->disableCreateButton();
            $grid->disableActions();
        }
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));
        // Tambahkan quick search
        $grid->quickSearch('nama', 'nickname');
        $grid->disableFilter();
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Asatidz::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nama', __('Nama'));
        $show->field('nickname', __('Nickname'));
        $show->field('no_hp', __('No hp'));
        $show->field('gender', __('Gender'));
        $show->field('alamat', __('Alamat'));
        $show->field('tempat_lahir', __('Tempat lahir'));
        $show->field('tanggal_lahir', __('Tanggal lahir'));
        $show->field('TMT', __('TMT'));
        $show->field('gelar_depan', __('Gelar depan'));
        $show->field('gelar_belakang', __('Gelar belakang'));
        $show->field('status_kawin', __('Status kawin'));
        $show->field('no_sk', __('No sk'));
        $show->field('foto_url', __('Foto url'));
        $show->field('rek_kjks', __('Rek kjks'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Asatidz());

        $form->text('nama', __('Nama'));
        $form->text('nickname', __('Nickname'));
        $form->text('no_hp', __('No hp'));
        $form->text('gender', __('Gender'))->default('L');
        $form->textarea('alamat', __('Alamat'));
        $form->text('tempat_lahir', __('Tempat lahir'));
        $form->date('tanggal_lahir', __('Tanggal lahir'))->default(date('Y-m-d'));
        $form->date('TMT', __('TMT'))->default(date('Y-m-d'));
        $form->text('gelar_depan', __('Gelar depan'));
        $form->text('gelar_belakang', __('Gelar belakang'));
        $form->text('status_kawin', __('Status kawin'))->default('Kawin');
        $form->text('no_sk', __('No sk'));
        $form->text('foto_url', __('Foto url'));
        $form->text('rek_kjks', __('Rek kjks'));

        return $form;
    }
}
