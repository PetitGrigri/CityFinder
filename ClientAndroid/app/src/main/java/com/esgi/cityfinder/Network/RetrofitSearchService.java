package com.esgi.cityfinder.Network;

import android.util.Log;

import com.esgi.cityfinder.Model.Image.ImageResult;
import com.esgi.cityfinder.Model.Image.Items;
import com.esgi.cityfinder.Model.SearchResult;
import com.esgi.cityfinder.Network.Services.IRetrofitSearchService;

import java.util.List;
import java.util.Map;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public class RetrofitSearchService implements ISearchService {

    private IRetrofitSearchService retrofitSearchService;

    private IRetrofitSearchService getRetrofitSearchService(){
        if(retrofitSearchService == null){
            retrofitSearchService = RetrofitSession.getInstance().create(IRetrofitSearchService.class);
        }
        return retrofitSearchService;
    }


    @Override
    public void search(String userToken, Map<String, Integer> searchMap, final IServiceResultListener<List<SearchResult>> iServiceResultListener) {

        getRetrofitSearchService().search(userToken,searchMap).enqueue(new Callback<List<SearchResult>>() {
            @Override
            public void onResponse(Call<List<SearchResult>> call, Response<List<SearchResult>> response) {

                ServiceResult<List<SearchResult>> result = new ServiceResult<List<SearchResult>>();

                if(response.isSuccessful()){
                    result.setData(response.body());
                } else {
                    result.setErrorMsg("Erreur de connexion : "+response.code());
                }

                if(iServiceResultListener != null){
                    iServiceResultListener.onResult(result);
                }

            }

            @Override
            public void onFailure(Call<List<SearchResult>> call, Throwable t) {
                if(iServiceResultListener != null){
                    iServiceResultListener.onResult(new ServiceResult<List<SearchResult>>(t.getMessage()));
                }
            }
        });

    }

    @Override
    public void getImageUrl(String url, IServiceResultListener<List<ImageResult>> iServiceResultListener) {

        getRetrofitSearchService().getImageUrl(url).enqueue(new Callback<List<ImageResult>>() {
            @Override
            public void onResponse(Call<List<ImageResult>> call, Response<List<ImageResult>> response) {

                if(response.isSuccessful()){

                    List<ImageResult> result = response.body();
                    Log.i("getImageUrl","Response : "+result.get(0).getKind());
/*
                    if (result != null) {
                        for (Items i : result.getItemsList()){
                            Log.i("getImageUrl","Response : "+i.getTitle());
                        }
                    }*/


                }

                // Log.i("getImageUrl","Response : "+response.body());
            }

            @Override
            public void onFailure(Call<List<ImageResult>> call, Throwable t) {
                Log.i("getImageUrl","Response : "+t.getMessage());
            }
        });

    }
}
