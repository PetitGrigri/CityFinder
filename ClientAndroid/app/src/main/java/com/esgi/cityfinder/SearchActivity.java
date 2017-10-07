package com.esgi.cityfinder;

import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.v4.util.ArrayMap;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;

import com.allattentionhere.fabulousfilter.AAH_FabulousFragment;

import java.util.List;
import java.util.Map;

public class SearchActivity extends AppCompatActivity implements AAH_FabulousFragment.Callbacks, AAH_FabulousFragment.AnimationListener {

    private MyFabFragment myFabFragment;
    private FloatingActionButton searchButton;
    private ArrayMap<String, List<String>> applied_filters = new ArrayMap<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_search);

        searchButton = (FloatingActionButton) findViewById(R.id.floatingActionButton);

        myFabFragment = MyFabFragment.newInstance();
        myFabFragment.setParentFab(searchButton);
        searchButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Log.i("SearchActivity","Search button clicked");
                myFabFragment.show(getSupportFragmentManager(), myFabFragment.getTag());
            }
        });

    }

    @Override
    public void onResult(Object result) {

        if(result != null){

            ArrayMap<String, List<String>> applied_filters = (ArrayMap<String, List<String>>) result;
            Log.i("SearchActivity","Result : "+applied_filters.size());

            for(Map.Entry<String, List<String>> entry : applied_filters.entrySet()){
                Log.i("SearchActivity","Entry : "+entry.getValue());
            }

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
