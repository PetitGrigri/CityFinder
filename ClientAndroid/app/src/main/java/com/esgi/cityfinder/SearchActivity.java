package com.esgi.cityfinder;

import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.v4.util.ArrayMap;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;

import com.allattentionhere.fabulousfilter.AAH_FabulousFragment;
import com.esgi.cityfinder.Adapter.CustomCityListAdapter;
import com.esgi.cityfinder.Fragment.SearchFragment;
import com.esgi.cityfinder.Model.Auth;
import com.esgi.cityfinder.Model.City;
import com.esgi.cityfinder.Model.Image.ImageResult;
import com.esgi.cityfinder.Model.SearchResult;
import com.esgi.cityfinder.Network.IServiceResultListener;
import com.esgi.cityfinder.Network.RetrofitSearchService;
import com.esgi.cityfinder.Network.ServiceResult;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import shivam.developer.featuredrecyclerview.FeatureLinearLayoutManager;
import shivam.developer.featuredrecyclerview.FeaturedRecyclerView;

public class SearchActivity extends AppCompatActivity implements AAH_FabulousFragment.Callbacks, AAH_FabulousFragment.AnimationListener {

    private SearchFragment searchFragment;
    private FloatingActionButton searchButton;
    private ArrayMap<String, List<String>> applied_filters = new ArrayMap<>();

    FeaturedRecyclerView featuredRecyclerView;
    List<City> cityList;
    CustomCityListAdapter customCityListAdapter;

    private Auth auth;
    private RetrofitSearchService searchService;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_search);

        Intent intent = getIntent();
        if (intent != null) {
            auth = intent.getParcelableExtra("auth");
        }

        cityList = getDefaultCityList();

        featuredRecyclerView = (FeaturedRecyclerView) findViewById(R.id.featured_recycler_view);
        FeatureLinearLayoutManager layoutManager = new FeatureLinearLayoutManager(this);
        featuredRecyclerView.setLayoutManager(layoutManager);
        customCityListAdapter = new CustomCityListAdapter(this, cityList);
        featuredRecyclerView.setAdapter(customCityListAdapter);

        searchButton = (FloatingActionButton) findViewById(R.id.floatingActionButton);

        searchFragment = SearchFragment.newInstance();
        searchFragment.setParentFab(searchButton);
        searchButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Log.i("SearchActivity", "SearchResult button clicked");
                //searchFragment.show(getSupportFragmentManager(), searchFragment.getTag());

                // TODO: 09/10/2017 testtttttttt
                String query = "Paris+France";
                String url = "https://www.googleapis.com/customsearch/v1?q="+query+"&key="+Const.GOOGLE_SEARCH_API_KEY+"&cx="+Const.GOOGLE_SEARCH_CX_KEY+"&alt=json";
                getSearchService().getImageUrl(url, new IServiceResultListener<List<ImageResult>>() {
                    @Override
                    public void onResult(ServiceResult<List<ImageResult>> result) {

                    }
                });

            }
        });

    }

    private List<City> getDefaultCityList() {

        //source : https://www.abritel.fr/info/guide/idees/vacances-theme/city-break-en-france

        List<City> cityList = new ArrayList<>();
        cityList.add(new City("Marseille", "La cosmopolite", R.drawable.marseille));
        cityList.add(new City("Bordeaux", "Grand cru français", R.drawable.bordeaux));
        cityList.add(new City("Lyon", "Ville Lumière", R.drawable.lyon));
        cityList.add(new City("Toulouse", "Cap sur la gastronomie", R.drawable.toulouse));
        cityList.add(new City("Montpellier", "Le trésor du Languedoc", R.drawable.montpellier));
        cityList.add(new City("Biarritz", "Le caractère basque", R.drawable.biarritz));
        cityList.add(new City("Nice", "La petite perle de la côte d'azur", R.drawable.nice));
        cityList.add(new City("Saint Malo", "La belle bretonne", R.drawable.saint_malo));
        cityList.add(new City("Annecy", "L'air pur des montagnes", R.drawable.annecy));
        cityList.add(new City("Paris", "La romantique", R.drawable.paris));

        return cityList;
    }

    private List<City> getEditedCityList() {

        //source : https://www.abritel.fr/info/guide/idees/vacances-theme/city-break-en-france

        List<City> cityList = new ArrayList<>();
        cityList.add(new City("Paris", "La romantique", R.drawable.paris));
        cityList.add(new City("Biarritz", "Le caractère basque", R.drawable.biarritz));
        cityList.add(new City("Lyon", "Ville Lumière", R.drawable.lyon));
        cityList.add(new City("Toulouse", "Cap sur la gastronomie", R.drawable.toulouse));
        cityList.add(new City("Montpellier", "Le trésor du Languedoc", R.drawable.montpellier));
        cityList.add(new City("Biarritz", "Le caractère basque", R.drawable.biarritz));
        cityList.add(new City("Nice", "La petite perle de la côte d'azur", R.drawable.nice));
        cityList.add(new City("Saint Malo", "La belle bretonne", R.drawable.saint_malo));
        cityList.add(new City("Bordeaux", "Grand cru français", R.drawable.bordeaux));
        cityList.add(new City("Marseille", "La cosmopolite", R.drawable.marseille));

        return cityList;
    }

    @Override
    public void onResult(Object result) {

        /**
         * Centrale :
         * > 20 km = 1
         * > 30 km = 2
         * > 80 km = 3
         * Null    = 0
         */

        if (result != null) {

            ArrayMap<String, List<String>> applied_filters = (ArrayMap<String, List<String>>) result;

            if (applied_filters.size() > 0) {

                getCityListSearchMap(getSearchBody(applied_filters));
            }

            //Log.i("SearchActivity", "Map : "+searchMap);

           /* cityList.clear();
            cityList.addAll(getEditedCityList());
            customCityListAdapter.notifyDataSetChanged();*/

        }

    }

    private void getCityListSearchMap(HashMap<String, Integer> searchMap) {

        String token;

        if ((token = auth.getToken()) != null) {
            getSearchService().search(token, searchMap, new IServiceResultListener<List<SearchResult>>() {
                @Override
                public void onResult(ServiceResult<List<SearchResult>> result) {

                    List<SearchResult> results = result.getData();
                    List<City> filteredCityList = new ArrayList<>();

                    for (SearchResult searchResult : results) {
                        Log.i("SearchActivityCustom", "Map : " + searchResult.toString());
                        filteredCityList.add(new City(searchResult.getCityName(), R.drawable.default_image));
                    }

                    cityList.clear();
                    cityList.addAll(filteredCityList);
                    customCityListAdapter.notifyDataSetChanged();

                    /*} else {
                        Toast.makeText(getBaseContext(),result.getErrorMsg(),Toast.LENGTH_SHORT).show();
                    }*/

                }
            });
        }
    }


    private HashMap<String, Integer> getSearchBody(ArrayMap<String, List<String>> applied_filters) {

        HashMap<String, Integer> searchMap = new HashMap<>();

        for (Map.Entry<String, List<String>> entry : applied_filters.entrySet()) {
            Log.i("SearchActivity", "Entry : " + entry.getKey());
            Log.i("SearchActivity", "Entry : " + entry.getValue());

            switch (entry.getKey()) {

                case Const.CENTRALES:

                    List<String> centraleValues = entry.getValue();
                    if (centraleValues.contains(Const.MORE_THAN_80)) {
                        searchMap.put(Const.API_CENTRALES, 3);
                    } else if (centraleValues.contains(Const.MORE_THAN_30)) {
                        searchMap.put(Const.API_CENTRALES, 2);
                    } else if (centraleValues.contains(Const.MORE_THAN_20)) {
                        searchMap.put(Const.API_CENTRALES, 1);
                    } else {
                        searchMap.put(Const.API_CENTRALES, 0);
                    }

                    break;

                case Const.MUSEES:

                    List<String> musseesValues = entry.getValue();
                    if (musseesValues.contains(Const.ESSENTIEL)) {
                        searchMap.put(Const.API_MUSSEES, 1);
                    } else {
                        searchMap.put(Const.API_MUSSEES, 0);
                    }

                    break;

                case Const.HOTELS:

                    List<String> hotelsValues = entry.getValue();
                    if (hotelsValues.contains(Const.ESSENTIEL)) {
                        searchMap.put(Const.API_HOTELS, 1);
                    } else {
                        searchMap.put(Const.API_HOTELS, 0);
                    }

                    break;

                case Const.POSTES:

                    List<String> postesValues = entry.getValue();
                    if (postesValues.contains(Const.ESSENTIEL)) {
                        searchMap.put(Const.API_POSTES, 1);
                    } else {
                        searchMap.put(Const.API_POSTES, 0);
                    }

                    break;
            }
        }

        return searchMap;
    }

    @Override
    public void onOpenAnimationStart() {

    }

    @Override
    public void onOpenAnimationEnd() {

    }

    @Override
    public void onCloseAnimationStart() {

    }

    @Override
    public void onCloseAnimationEnd() {

    }

    public ArrayMap<String, List<String>> getApplied_filters() {
        return applied_filters;
    }

    public RetrofitSearchService getSearchService() {

        if (searchService == null) {
            searchService = new RetrofitSearchService();
        }

        return searchService;
    }
}

