package com.esgi.cityfinder;

import android.content.Intent;
import android.graphics.Bitmap;
import android.os.AsyncTask;
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
    List<SearchResult> searchResults;
    CustomCityListAdapter customCityListAdapter;

    public static Auth auth;
    private RetrofitSearchService searchService;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_search);

        Intent intent = getIntent();
        if (intent != null) {
            auth = intent.getParcelableExtra("auth");
        }

        searchResults = getDefaultSearchList();

        featuredRecyclerView = (FeaturedRecyclerView) findViewById(R.id.featured_recycler_view);
        FeatureLinearLayoutManager layoutManager = new FeatureLinearLayoutManager(this);
        featuredRecyclerView.setLayoutManager(layoutManager);
        customCityListAdapter = new CustomCityListAdapter(this, searchResults);
        featuredRecyclerView.setAdapter(customCityListAdapter);

        searchButton = (FloatingActionButton) findViewById(R.id.floatingActionButton);

        searchFragment = SearchFragment.newInstance();
        searchFragment.setParentFab(searchButton);
        searchButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Log.i("SearchActivity", "SearchResult button clicked");
                searchFragment.show(getSupportFragmentManager(), searchFragment.getTag());
            }
        });
    }

    private List<SearchResult> getDefaultSearchList() {

        //source : https://www.abritel.fr/info/guide/idees/vacances-theme/city-break-en-france

        List<SearchResult> resultList = new ArrayList<>();
        /*resultList.add(new SearchResult("Marseille", R.drawable.marseille));
        resultList.add(new SearchResult("Bordeaux", R.drawable.bordeaux));
        resultList.add(new SearchResult("Lyon", R.drawable.lyon));
        resultList.add(new SearchResult("Toulouse", R.drawable.toulouse));
        resultList.add(new SearchResult("Montpellier", R.drawable.montpellier));
        resultList.add(new SearchResult("Biarritz", R.drawable.biarritz));
        resultList.add(new SearchResult("Nice", R.drawable.nice));
        resultList.add(new SearchResult("Saint Malo", R.drawable.saint_malo));
        resultList.add(new SearchResult("Annecy", R.drawable.annecy));
        resultList.add(new SearchResult("Paris", R.drawable.paris));*/

        return resultList;
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
        }
    }

    private void getCityListSearchMap(final HashMap<String, Integer> searchMap) {

        String token;

        if ((token = auth.getToken()) != null) {
            getSearchService().search(token, searchMap, new IServiceResultListener<List<SearchResult>>() {
                @Override
                public void onResult(ServiceResult<List<SearchResult>> result) {

                    List<SearchResult> results = result.getData();

                    searchResults.clear();
                    searchResults.addAll(results);
                    customCityListAdapter.notifyDataSetChanged();
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

