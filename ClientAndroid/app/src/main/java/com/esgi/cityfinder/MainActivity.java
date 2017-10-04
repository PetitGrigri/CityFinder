package com.esgi.cityfinder;

import android.graphics.Color;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

import com.hololo.tutorial.library.Step;
import com.hololo.tutorial.library.TutorialActivity;

public class MainActivity extends TutorialActivity implements View.OnClickListener{

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //setContentView(R.layout.activity_main);
        addFragment(new Step.Builder().setTitle("This is header")
                .setContent("This is content")
                .setDrawable(R.drawable.eiffle_tower)
                .setBackgroundColor(Color.parseColor("#FF0957")) // int background color
                .setSummary("This is summary")
                .build());

        addFragment(new Step.Builder().setTitle("This is header 2")
                .setContent("This is content")
                .setDrawable(R.drawable.geode)
                .setBackgroundColor(Color.parseColor("#FF0957")) // int background color
                .setSummary("This is summary")
                .build());

    }
}
