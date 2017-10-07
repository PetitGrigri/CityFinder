package com.esgi.cityfinder;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.widget.TextView;

import com.esgi.cityfinder.Model.City;
import com.flaviofaria.kenburnsview.KenBurnsView;


public class DetailActivity extends AppCompatActivity {

    Intent intent;
    TextView tvCityName, tvCityDetail;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail);

        tvCityName = (TextView)findViewById(R.id.tv_city_name);
        tvCityDetail = (TextView)findViewById(R.id.tv_city_detail);

        KenBurnsView kenBurnsView = (KenBurnsView) findViewById(R.id.detail_image_view);

        if ((intent = getIntent()) != null) {
            City mCity = intent.getParcelableExtra("cityObject");
            kenBurnsView.setImageResource(mCity.getPhotoId());
            tvCityName.setText(mCity.getName());
            tvCityDetail.setText(mCity.getDetail());
        }



    }
}
