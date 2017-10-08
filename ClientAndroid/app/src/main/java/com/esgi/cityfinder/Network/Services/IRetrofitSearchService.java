package com.esgi.cityfinder.Network.Services;

import com.esgi.cityfinder.Model.Search;

import java.util.Map;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.Header;
import retrofit2.http.POST;
import retrofit2.http.Path;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public interface IRetrofitSearchService {

    @POST("/search")
    Call<Search> search(
            @Header("X-Auth-Token") String userToken,
            @Body Map<String, String> searchMap
    );


    @GET("/search/detail/{search_id}")
    Call<Search> detailSearch(
            @Header("X-Auth-Token") String userToken,
            @Path("search_id") int searchId
    );

}
