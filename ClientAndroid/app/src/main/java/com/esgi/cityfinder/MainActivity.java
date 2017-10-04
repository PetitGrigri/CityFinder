package com.esgi.cityfinder;

import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import com.hololo.tutorial.library.Step;
import com.hololo.tutorial.library.TutorialActivity;

public class MainActivity extends TutorialActivity implements View.OnClickListener{

    Button buttonFinish;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //setContentView(R.layout.activity_main);

        buttonFinish = (Button)findViewById(R.id.next);

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

        buttonFinish.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Toast.makeText(getBaseContext(),"Finished",Toast.LENGTH_SHORT).show();
                startActivity(new Intent(MainActivity.this,SearchActivity.class));
            }
        });

    }
}
