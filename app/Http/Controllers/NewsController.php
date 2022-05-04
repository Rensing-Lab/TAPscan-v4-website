<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Illuminate\View\View;
use \App\Tables\NewsTable;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $news = DB::table('news')
                    ->get()
                    ->reverse();
        return view('news.index', ['news' => $news]);
    }

    public function table(): View
    {
        $table = (new NewsTable())->setup();

        return view('news.table', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'name' => 'required',
        'content' => 'required'
      ]);

    News::create($request->all());

    return redirect()->route('news.index')
    ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
     public function show(News $new, $id)
     {
       $news_data = News::findOrFail($id);
       return view('news.show', compact('news_data'));
         //
     }

     /**
      * Display the specified resource.
      *
      * @param  \App\Models\News  $news
      * @return \Illuminate\Http\Response
      */
    public function edit(News $new, $id)
    {
      $news_data = News::findOrFail($id);
      return view('news.edit', compact('news_data'));
    }


   public function update(Request $request, News $new, $id)
   {        //

       // validate
       // read more on validation at http://laravel.com/docs/validation
       $request->validate([
           'name'       => 'required',
           'content'      => 'required'
       ]);

       $news_data = News::find($id);

       $news_data->name = $request->name;
       $news_data->content = $request->content;

           // store
       $news_data->save();

       return redirect()->route('news.index')
         ->with('success', 'Product updated successfully');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
     public function destroy(News $newss, $id)
     {
       $news_data = $newss::find($id);
       $news_data->delete();

       return redirect()->route('news.index')
         ->with('success', 'Product deleted successfully');
         //
     }
}
