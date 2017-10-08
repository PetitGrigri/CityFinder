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

import java.util.ArrayList;
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

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_search);

        Intent intent = getIntent();
        if(intent != null){
            auth = intent.getParcelableExtra("auth");
            Log.i("SearchActivity","Token : "+auth.getToken());
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
                Log.i("SearchActivity", "Search button clicked");
                searchFragment.show(getSupportFragmentManager(), searchFragment.getTag());
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

        if (result != null) {

            ArrayMap<String, List<String>> applied_filters = (ArrayMap<String, List<String>>) result;
            Log.i("SearchActivity", "Result : " + applied_filters.size());

            for (Map.Entry<String, List<String>> entry : applied_filters.entrySet()) {
                Log.i("SearchActivity", "Entry : " + entry.getValue());
            }

            cityList.clear();
            cityList.addAll(getEditedCityList());
            customCityListAdapter.notifyDataSetChanged();

        }

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
}
