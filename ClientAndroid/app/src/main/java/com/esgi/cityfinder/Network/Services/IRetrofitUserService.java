package com.esgi.cityfinder.Network.Services;

import com.esgi.cityfinder.Model.User;

import java.util.Map;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.DELETE;
import retrofit2.http.Header;
import retrofit2.http.PATCH;
import retrofit2.http.POST;
import retrofit2.http.Path;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public interface IRetrofitUserService {

    @POST("user")
    Call<User> registerUser(@Body Map<String,String> user);

    @PATCH("user/{id}")
    Call<User> updateUser(
            @Header("X-Auth-Token") String userToken,
            @Path("id") int id,
            @Body Map<String, String> updateMap
    );

    @DELETE("user/{id}")
    Call<Void> deleteUser(
            @Header("X-Auth-Token") String userToken,
            @Path("id") int id
    );



}
