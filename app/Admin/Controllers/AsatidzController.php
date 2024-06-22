<?php

namespace App\Admin\Controllers;

use App\Models\Asatidz;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Hash;
use OpenAdmin\Admin\Auth\Database\Administrator;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\TUsrPerson;
use OpenAdmin\Admin\Facades\Admin;

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
        // $user = \Auth::user();
        // $lembaga_id = TUsrPerson::where('user_id', $user->id)->pluck('lembaga_id')->first();
        $user = Admin::guard()->user();
        $lembaga_id = $user->tUsrPerson()->first()->lembaga_id;
        $grid = new Grid(new TUsrPerson());
        // dd($grid);
        $grid->model()->where('lembaga_id', $lembaga_id);
        $grid->column('induk', __('Induk'));
        $grid->column('asatidz.nama', __('Nama'))->sortable();
        $grid->column('asatidz.nickname', __('Nickname'));
        $grid->column('asatidz.no_hp', __('No hp'));
        $grid->column('asatidz.email', __('Surel'));
        $grid->column('asatidz.gender', __('Gender'));
        $grid->column('asatidz.alamat', __('Alamat'))->hide();
        $grid->column('asatidz.tempat_lahir', __('Tmpt. lahir'))->hide();
        $grid->column('asatidz.tanggal_lahir', __('Tgl. lahir'))->hide();
        $grid->column('jabatan.jabatan', __('Jabatan'))->filter('like');
        $grid->column('asatidz.TMT', __('TMT'))->hide();
        $grid->column('asatidz.gelar_depan', __('Gelar depan'))->hide();
        $grid->column('asatidz.gelar_belakang', __('Gelar belakang'))->hide();
        $grid->column('asatidz.status_kawin', __('Status kawin'))->hide();
        $grid->column('asatidz.no_sk', __('No sk'))->hide();
        $grid->column('asatidz.foto_url', __('Foto url'))->hide();
        $grid->column('asatidz.rek_kjks', __('Rek kjks'))->hide();
        $grid->column('lembaga_id', __('id Lembaga'))->hide();
        $grid->column('isActive', __('Status Aktif'))->display(function ($isActive) {
            return $isActive ? 'Aktif' : 'Non Aktif';
        })->hide();
        if(!$user->can('guru.manage')){
            $grid->disableCreateButton();
            $grid->disableActions();
        }
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
        $show = new Show(TUsrPerson::findOrFail($id));
        $show->field('induk', __('No. Induk'));
        $show->field('asatidz.nama', __('Nama'));
        $show->field('asatidz.nickname', __('Nickname'));
        $show->field('asatidz.no_hp', __('No hp'));
        $show->field('asatidz.email', __('Surel'));
        $show->field('asatidz.gender', __('Gender'));
        $show->field('asatidz.alamat', __('Alamat'));
        $show->field('asatidz.tempat_lahir', __('Tempat lahir'));
        $show->field('asatidz.tanggal_lahir', __('Tanggal lahir'));
        $show->field('asatidz.TMT', __('TMT'));
        $show->field('asatidz.gelar_depan', __('Gelar depan'));
        $show->field('asatidz.gelar_belakang', __('Gelar belakang'));
        $show->field('asatidz.status_kawin', __('Status kawin'));
        $show->field('asatidz.no_sk', __('No sk'));
        $show->field('asatidz.foto_url', __('Foto url'));
        $show->field('asatidz.rek_kjks', __('Rek kjks'));
        $show->field('user.username', __('Username'));
        // $show->field('created_at', __('Created at'));
        // $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    
     protected function form(){
        $attribut = $this->ambilAtribut();
        $form = new Form(new TUsrPerson());
        $form->text('induk', __('Induk'))->default($attribut['induk'])->disable();
        $form->text('asatidz.nama', __('Nama'))->required();
        $form->text('asatidz.nik', __('NIK'))
            ->attribute('type', 'number')
            ->required();
        $form->text('asatidz.nickname', __('Nama Panggilan'));
        $form->phonenumber('asatidz.no_hp', __('No hp'));
        $form->email('asatidz.email', __('e-Mail'));
        $form->radio('asatidz.gender', __('Gender'))->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])->default('L');
        $form->radio('asatidz.status_kawin', __('Status Perkawinan'))->options(['Kawin' => 'Kawin', 'Belum Kawin' => 'Belum Kawin'])->default('Belum Kawin');
        $form->textarea('asatidz.alamat', __('Alamat'));
        $form->text('asatidz.tempat_lahir', __('Tempat lahir'));
        $form->date('asatidz.tanggal_lahir', __('Tanggal lahir'))->default(date('1990-01-01'));
        $form->date('asatidz.TMT', __('TMT'))->default(date('Y-m-d'));
        $form->text('asatidz.gelar_depan', __('Gelar depan'));
        $form->text('asatidz.gelar_belakang', __('Gelar belakang'));
        $form->text('asatidz.no_sk', __('No sk'));
        $form->text('asatidz.foto_url', __('Foto url'));
        $form->text('asatidz.rek_kjks', __('Rek kjks'));
        $jabatans = Jabatan::all()->pluck('jabatan','id')->toArray();
        $options = ['' => 'Pilih Jabatan...'] + $jabatans;
        $form->select('jabatan_id', __('Jabatan'))->options($options);
        $form->radio('isActive', __('Status Aktif'))->options(['1' => 'Aktif', '2' => 'Non Aktif'])->default('1');
        $form->disableReset();

        //hiden form
        $form->hidden('person_id')->default('2');
        $form->saving(function (Form $form) {
            $attribut = $this->ambilAtribut();
            dd($form->asatidz['nik']);
            $form->induk=$attribut['induk'];
            $form->lembaga_id=$attribut['lembaga_id'];
            $admin = Administrator::create([
                'username' => $form->lembaga_id.$form->induk,
                'password' => Hash::make($form->asatidz['tanggal_lahir']),
                'name'     => $form->asatidz['nama'],
            ]);
            $form->user_id=$admin->id;
            $asatidz = new Asatidz();
            $asatidz->nik=$form->nik;
            // dd($form->user_id);
        });
        return $form;
    }
    private function ambilAtribut(){
        $user = Admin::guard()->user();
        $lembaga_id = TUsrPerson::where('user_id', $user->id)->pluck('lembaga_id')->first();
        $year = now()->format('Y');
        $month = now()->format('m');
        $lastInduk = TUsrPerson::where('lembaga_id', $lembaga_id)->orderBy('induk', 'desc')->first()->value('induk');
        $ym = $year . $month . '000';
        // $lastUserId = User::max('id');
        if ($lastInduk>$ym) {
            $lastNumber = (int) substr($lastInduk, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }
        $addInduk = $year . $month . $newNumber;
        $attribut = ['induk'=> $addInduk, 'lembaga_id'=>$lembaga_id];
        return $attribut;
    }
}
