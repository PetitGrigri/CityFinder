package com.esgi.cityfinder.Network.Services;

import com.esgi.cityfinder.Model.Auth;
import com.esgi.cityfinder.Model.User;

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

public interface IRetrofitAuthService {

    @POST("/CityFinder/SymfonyApi/web/app_dev.php/authentication")
    Call<Auth> authentication(@Body Map<String,String> userMap);

    @GET("/authentication")
    Call<User> getAuthUser(@Header("X-Auth-Token") String userToken);

}
