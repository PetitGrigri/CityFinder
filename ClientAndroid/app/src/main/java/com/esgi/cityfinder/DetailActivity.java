package com.esgi.cityfinder;

import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.widget.TextView;
import android.widget.Toast;

import com.esgi.cityfinder.Adapter.CustomCityDetailListAdapter;
import com.esgi.cityfinder.Model.Centrales.Centrales20Km;
import com.esgi.cityfinder.Model.Centrales.Centrales30Km;
import com.esgi.cityfinder.Model.Centrales.Centrales80Km;
import com.esgi.cityfinder.Model.DetailCity;
import com.esgi.cityfinder.Model.DetailSearch;
import com.esgi.cityfinder.Model.Hotel.HotelLocatedIn;
import com.esgi.cityfinder.Model.Hotel.HotelsNear;
import com.esgi.cityfinder.Model.Image;
import com.esgi.cityfinder.Model.Musees;
import com.esgi.cityfinder.Model.Poste;
import com.esgi.cityfinder.Model.SearchResult;
import com.esgi.cityfinder.Network.IServiceResultListener;
import com.esgi.cityfinder.Network.RetrofitSearchService;
import com.esgi.cityfinder.Network.ServiceResult;
import com.flaviofaria.kenburnsview.KenBurnsView;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.ArrayList;
import java.util.List;


public class DetailActivity extends AppCompatActivity {

    Intent intent;
    TextView tvCityName;
    SearchResult searchResult;

    RetrofitSearchService retrofitSearchService;

    private RecyclerView recyclerView;
    private CustomCityDetailListAdapter adapter;

    private KenBurnsView kenBurnsView;

    private List<DetailCity> detailCityList = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail);

        tvCityName = (TextView) findViewById(R.id.tv_city_name);

        kenBurnsView = (KenBurnsView) findViewById(R.id.detail_image_view);

        recyclerView = (RecyclerView) findViewById(R.id.rv_detail_list);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        adapter = new CustomCityDetailListAdapter(this, detailCityList);
        recyclerView.setAdapter(adapter);

        if ((intent = getIntent()) != null) {
            searchResult = intent.getParcelableExtra("cityObject");

            if (searchResult.getImageId() != 0) {
                kenBurnsView.setImageResource(searchResult.getImageId());
            } else {
                kenBurnsView.setImageResource(R.drawable.default_image);
            }

            tvCityName.setText(searchResult.getCityName());
            getCityDeatail();
        }

    }

    private void setWikiImage(String cityName){

        String auth = SearchActivity.auth.getToken();

        getRetrofitSearchService().getImageUrl(auth, cityName, new IServiceResultListener<Image>() {
            @Override
            public void onResult(ServiceResult<Image> result) {

                String url = result.getData().getUrl();

                if(url != null){
                    kenBurnsView.setImageURI(Uri.parse(url));
                    Toast.makeText(getBaseContext(),"Image setted",Toast.LENGTH_SHORT).show();
                }

            }
        });
    }

    private void getCityDeatail() {

        String token = SearchActivity.auth.getToken();
        Integer cityId = searchResult.getId();
        Log.i("DetailActivity", "Id : " + cityId);

        if (token != null && !token.isEmpty()) {

            if (cityId != null) {

                getRetrofitSearchService().detailSearch(token, cityId, new IServiceResultListener<DetailSearch>() {
                    @Override
                    public void onResult(ServiceResult<DetailSearch> result) {

                        DetailSearch detailSearch = result.getData();

                        if (detailSearch != null) {
                            updateListView(detailSearch);
                            // Toast.makeText(getBaseContext(), "update en cours", Toast.LENGTH_SHORT).show();
                        } else {
                            Toast.makeText(getBaseContext(), result.getErrorMsg(), Toast.LENGTH_SHORT).show();
                        }
                    }
                });
            }
        }
    }

    private void updateListView(DetailSearch detailSearch) {


        List<DetailCity> detailCityListTmp = new ArrayList<>();

        List<Centrales80Km> centrales80KmList = detailSearch.getCentrales80Km();
        if (centrales80KmList != null && centrales80KmList.size() > 0) {
            detailCityListTmp.add(new DetailCity("Centrale > 80 Km", true));

            for (Centrales80Km centrales80Km : centrales80KmList) {
                detailCityListTmp.add(new DetailCity(centrales80Km.getName(), false));
            }

        }

        List<Centrales30Km> centrales30KmList = detailSearch.getCentrales30Km();
        if (centrales30KmList != null && centrales30KmList.size() > 0) {
            detailCityListTmp.add(new DetailCity("Centrale > 30 Km", true));

            for (Centrales30Km centrales30Km : centrales30KmList) {
                detailCityListTmp.add(new DetailCity(centrales30Km.getName(), false));
            }

        }

        List<Centrales20Km> centrales20KmList = detailSearch.getCentrales20Km();
        if (centrales20KmList != null && centrales20KmList.size() > 0) {
            detailCityListTmp.add(new DetailCity("Centrale > 20 Km", true));

            for (Centrales20Km centrales20Km : centrales20KmList) {
                detailCityListTmp.add(new DetailCity(centrales20Km.getName(), false));
            }

        }

        List<HotelsNear> hotelsNearList = detailSearch.getHotelsNearList();
        List<HotelLocatedIn> hotelLocatedIn = detailSearch.getHotelLocatedInList();

        if ((hotelsNearList != null && hotelsNearList.size() > 0) || (hotelLocatedIn != null && hotelLocatedIn.size() > 0)) {
            detailCityListTmp.add(new DetailCity("Hotels", true));
        }

        if (hotelsNearList != null && hotelsNearList.size() > 0) {
            for (HotelsNear hotelsNear : hotelsNearList) {
                detailCityListTmp.add(new DetailCity(hotelsNear.getName(), false));
            }
        }

        if (hotelLocatedIn != null && hotelLocatedIn.size() > 0) {
            for (HotelLocatedIn hotelIn : hotelLocatedIn) {
                detailCityListTmp.add(new DetailCity(hotelIn.getName(), false));
            }
        }

        List<Musees> museesList = detailSearch.getMuseesList();
        if (museesList != null && museesList.size() > 0) {
            detailCityListTmp.add(new DetailCity("Musées", true));

            for (Musees musees : museesList) {
                detailCityListTmp.add(new DetailCity(musees.getName(), false));
            }
        }

        List<Poste> posteList = detailSearch.getPosteList();
        if (posteList != null && posteList.size() > 0) {
            detailCityListTmp.add(new DetailCity("Postes", true));

            for (Poste poste : posteList) {
                detailCityListTmp.add(new DetailCity(poste.getName(), false));
            }
        }

        //Toast.makeText(getBaseContext(), "Data setted", Toast.LENGTH_SHORT).show();

        detailCityList.clear();
        detailCityList.addAll(detailCityListTmp);
        adapter.notifyDataSetChanged();
    }

    public RetrofitSearchService getRetrofitSearchService() {

        if (retrofitSearchService == null) {
            retrofitSearchService = new RetrofitSearchService();
        }
        return retrofitSearchService;
    }
}
