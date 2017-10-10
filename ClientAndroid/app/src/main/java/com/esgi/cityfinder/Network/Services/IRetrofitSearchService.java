package com.esgi.cityfinder.Network.Services;

import android.graphics.Bitmap;

import com.esgi.cityfinder.Model.DetailSearch;
import com.esgi.cityfinder.Model.Flickr.FlickrImage;
import com.esgi.cityfinder.Model.Flickr.Photos;
import com.esgi.cityfinder.Model.Image;
import com.esgi.cityfinder.Model.SearchResult;

import java.util.List;
import java.util.Map;

import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.Header;
import retrofit2.http.POST;
import retrofit2.http.Path;
import retrofit2.http.Url;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public interface IRetrofitSearchService {

    @POST("/CityFinder/SymfonyApi/web/app_dev.php/search")
    Call<List<SearchResult>> search(
            @Header("X-Auth-Token") String userToken,
            @Body Map<String, Integer> searchMap
    );


    @GET("/CityFinder/SymfonyApi/web/app_dev.php/search/detail/{searchId}")
    Call<DetailSearch> detailSearch(
            @Header("X-Auth-Token") String userToken,
            @Path("searchId") int searchId
    );

    @GET
    Call<Image> getImageUrl(
            @Header("X-Auth-Token") String userToken,
            @Path("searchId") int searchId
    );

}
