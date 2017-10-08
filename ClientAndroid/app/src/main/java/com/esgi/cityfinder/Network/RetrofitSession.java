package com.esgi.cityfinder.Network;

import com.esgi.cityfinder.Const;

import okhttp3.OkHttpClient;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public class RetrofitSession {

    private static Retrofit retrofit;

    public static Retrofit getInstance(){

        if(retrofit == null){

            OkHttpClient.Builder okHttpClient = new OkHttpClient.Builder()
                    .addInterceptor(new HttpLoggingInterceptor()
                            .setLevel(HttpLoggingInterceptor.Level.BODY));

            retrofit = new Retrofit.Builder()
                    .baseUrl(Const.URL)
                    .addConverterFactory(GsonConverterFactory.create())
                    .client(okHttpClient.build())
                    .build();
        }

        return retrofit;
    }

}
