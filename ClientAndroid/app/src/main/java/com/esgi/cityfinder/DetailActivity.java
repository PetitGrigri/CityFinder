package com.esgi.cityfinder;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.TextView;

import com.esgi.cityfinder.Model.SearchResult;
import com.esgi.cityfinder.Network.RetrofitSearchService;
import com.flaviofaria.kenburnsview.KenBurnsView;


public class DetailActivity extends AppCompatActivity {

    Intent intent;
    TextView tvCityName, tvCityDetail;
    SearchResult searchResult;

    RetrofitSearchService retrofitSearchService;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail);

        tvCityName = (TextView) findViewById(R.id.tv_city_name);
        tvCityDetail = (TextView) findViewById(R.id.tv_city_detail);

        KenBurnsView kenBurnsView = (KenBurnsView) findViewById(R.id.detail_image_view);

        if ((intent = getIntent()) != null) {
            searchResult = intent.getParcelableExtra("cityObject");
            kenBurnsView.setImageResource(searchResult.getImageId());
            tvCityName.setText(searchResult.getCityName());
            getCityDeatail();
        }

    }

    private void getCityDeatail(){

        String token = SearchActivity.auth.getToken();

        Log.i("DetailActivity","Id : "+searchResult.getId());

        if(token != null) {
            //getRetrofitSearchService().detailSearch(token,);
        }

    }

    public RetrofitSearchService getRetrofitSearchService() {

        if (retrofitSearchService == null) {
            retrofitSearchService = new RetrofitSearchService();
        }
        return retrofitSearchService;
    }
}
