package com.esgi.cityfinder.Adapter;

import android.content.Context;
import android.content.Intent;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.esgi.cityfinder.DetailActivity;
import com.esgi.cityfinder.Model.SearchResult;
import com.esgi.cityfinder.R;
import com.squareup.picasso.Picasso;

import java.util.List;

import shivam.developer.featuredrecyclerview.FeatureRecyclerViewAdapter;

/**
 * Created by Asifadam93 on 07/10/2017.
 */

public class CustomCityListAdapter extends FeatureRecyclerViewAdapter<CustomCityListAdapter.CustomRecyclerViewHolder> {

    private List<SearchResult> dataList;
    private Context context;

    public CustomCityListAdapter(Context context, List<SearchResult> list) {
        this.dataList = list;
        this.context = context;
    }

    @Override
    public CustomRecyclerViewHolder onCreateFeaturedViewHolder(ViewGroup parent, int viewType) {
        return new CustomRecyclerViewHolder(
                LayoutInflater.from(parent.getContext())
                        .inflate(R.layout.simple_reycler_view_layout, parent, false));
    }

    @Override
    public void onBindFeaturedViewHolder(CustomRecyclerViewHolder holder, int position) {

        SearchResult searchResult = dataList.get(position);

        Log.i("CustomApapter", "Res : " + searchResult.getImageId());

        Picasso.with(context)
                .load(searchResult.getImageId()).into(holder.ivBackground);

        holder.tvHeading.setText(searchResult.getCityName());
        //holder.tvDetail.setText(mCity.getDetail());
    }

    @Override
    public int getFeaturedItemsCount() {
        return dataList.size();
    }

    @Override
    public void onSmallItemResize(CustomRecyclerViewHolder holder, int position, float offset) {
        holder.tvHeading.setAlpha(offset / 100f);
        // holder.tvDetail.setAlpha(offset / 100f);
    }

    @Override
    public void onBigItemResize(CustomRecyclerViewHolder holder, int position, float offset) {
        holder.tvHeading.setAlpha(offset / 100f);
        // holder.tvDetail.setAlpha(offset / 100f);
    }

    class CustomRecyclerViewHolder extends RecyclerView.ViewHolder {

        ImageView ivBackground;
        TextView tvHeading, tvDetail;
        RelativeLayout relativeLayout;

        CustomRecyclerViewHolder(View itemView) {
            super(itemView);

            ivBackground = itemView.findViewById(R.id.iv_background);
            tvHeading = itemView.findViewById(R.id.tv_heading);
            //tvDetail = (TextView) itemView.findViewById(R.id.tv_detail);
            relativeLayout = itemView.findViewById(R.id.rl_content);

            relativeLayout.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    SearchResult searchResult = dataList.get(getAdapterPosition());
                    Log.i("CustomRecyclerView", "City : " + searchResult.getImageId());

                    Intent intent = new Intent(context, DetailActivity.class);
                    intent.putExtra("cityObject", searchResult);
                    context.startActivity(intent);
                }
            });
        }
    }
}
