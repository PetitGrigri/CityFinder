package com.esgi.cityfinder.Network;

import com.esgi.cityfinder.Model.Auth;
import com.esgi.cityfinder.Model.SearchResult;
import com.esgi.cityfinder.Network.Services.IRetrofitAuthService;
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
}
