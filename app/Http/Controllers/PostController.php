<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\TagModel;
use Illuminate\Support\Facades\Session;
use App\Models\PostModel;
use App\Models\EmailModel;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    // Menampilkan List Post
    public function index(Request $request)
    {
        $request = $request->all();
        if (!empty($request)) {
            // Search Post
            $data['post'] = PostModel::search($request);
        } else {
            $data['post'] = PostModel::get_post();
        }
        return view('admin.post.index', $data);
    }

    // Menampilkan halaman membuat post
    public function create()
    {
        $data['category'] = CategoryModel::get_category();
        $data['tag'] = TagModel::get_tag();
        return view('admin.post.create', $data);
    }

    // Proses membuat post
    public function store(Request $request)
    {
        $this->validate($request, [
            'post_title' => 'required',
            'post_content' => 'required',
            'category_id' => 'required',
            'tag' => 'required',
            'featured' => 'required|image|max:2048'
        ]);
        $request = $request->all();
        PostModel::create_post($request);

        // Kirim Email Setelah membuat post
        $data = array(
            'post' => $request['post_title'],
            'slug' => str_slug($request['post_title']),
            'email' => EmailModel::all()
        );

        foreach ($data['email'] as $item) {
            Mail::send('email', $data, function ($mail) use ($data, $item) {
                $mail->to($item->email, 'GBPS')
                    ->subject('New Post');
                $mail->from('granitebagas28@gmail.com', 'Website MyMind');
            });
        }

        if (Mail::failures()) {
            Session::flash('error', 'Email Gagal Dikirim');
        }
        Session::flash('success', 'Email Berhasil Dikirim');

        Session::flash('success', 'Post Created');
        return redirect()->route('post.index');
    }

    // Menampilkan halaman edit post
    public function edit($id)
    {
        $data['category'] = CategoryModel::get_category();
        $data['tag'] = TagModel::get_tag();
        $data['post'] = PostModel::get_post_id($id);
        return view('admin.post.edit', $data);
    }

    // Proses edit post
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'post_title' => 'required',
            'post_content' => 'required',
            'category_id' => 'required',
            'tag' => 'required',
            'featured' => 'image|max:2048'
        ]);
        if ($request->hasFile('featured')) {
            $featured = $request->featured;
            $featured_name = time() . $featured->getClientOriginalName();
            $featured->move('images/posts', $featured_name);
            PostModel::update_featured($featured_name, $id);
        }
        $request = $request->all();
        PostModel::update_post($request, $id);
        Session::flash('success', 'Post Updated');
        return redirect()->route('post.index');
    }

    // Fungsi hapus/trash post
    public function destroy($id)
    {
        PostModel::delete_post($id);
        Session::flash('error', 'Post Trashed');
        return redirect()->route('post.index');
    }

    // Menampilkan trashed post
    public function trashed()
    {
        $data['post'] = PostModel::trashed_post();
        return view('admin.post.trashed', $data);
    }

    // Proses restore post
    public function restored($id)
    {
        PostModel::restore($id);
        Session::flash('success', 'Post Restored');
        return redirect()->route('post.index');
    }

    // Menghapus post secara permanen
    public function killed($id)
    {
        PostModel::killed($id);
        Session::flash('error', 'Post Permanently Deleted');
        return redirect()->route('post.trashed');
    }

    // Menyimpan Post Sebagai Publish / UnPublished
    public function drafted($id)
    {
        // Default post yang terpublish -> publish == 1
        if (PostModel::draft($id)) {
            Session::flash('success', 'Post Save As Draft');
        } else {
            Session::flash('success', 'Post Published');
        }
        return redirect()->route('post.index');
    }
}