<?php

namespace App\Http\Controllers\Api;

use App\Models\Seo;
use Illuminate\Http\Request;
use App\Http\Resources\SeoResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\SeoCollection;
use App\Http\Requests\Admin\SeoRequest;

class SeoController extends Controller
{
    // Route::get('/seo', function () {
//     return App\Models\Seo::where('site', 'alumni')->where('module', 'auth')->where('page', 'register')->first();
// });

    public function getSeoData(Request $request) {
        // $seoData = Seo::where('site', $request->site)->where('page_url', $request->page_url)->first();
        $seoData = Seo::where('site', $request->site)->where('page_url', 'LIKE', '%' . $request->page_url)->first();

        return response()->json([
            'data' => $seoData
        ]);
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Seo::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            return new SeoCollection($query);
        }
    }

    public function store(SeoRequest $request)
    {
        // // Assuming you have already validated the request and stored the data in $data
        // $data = $request->validated();

        // // Get the 'page_url' from the $data array
        // $page_url = $data['page_url'];

        // // Use parse_url to extract the host from the 'page_url'
        // $host = parse_url($page_url, PHP_URL_HOST);

        // // Find the position of the host in the 'page_url'
        // $position = strpos($page_url, $host);

        // // If the host is found in the 'page_url', remove it along with the scheme (e.g., http:// or https://)
        // if ($position !== false) {
        //     $relativeUrl = substr($page_url, $position + strlen($host));
        // } else {
        //     // If the host is not found, the 'page_url' may already be a relative URL
        //     $relativeUrl = $page_url;
        // }

        // // Create the SEO record with the updated 'page_url'
        // $data['page_url'] = $relativeUrl;
        // $seo = Seo::create($data);


        $data = $request->validated();
        $seo = Seo::create($data);
        return new SeoResource($seo);
    }

    public function show(Seo $seo)
    {

    }

    public function update(SeoRequest $request, Seo $seo)
    {
        $data = $request->validated();
        $seo->update($data);

        return new SeoResource($seo);
    }

    public function destroy(Seo $seo)
    {
        $seo->delete();

        return response()->noContent();
    }
}
