package com.esgi.cityfinder.Adapter;

import android.content.Context;
import android.graphics.Typeface;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.esgi.cityfinder.Model.DetailCity;
import com.esgi.cityfinder.R;

import org.w3c.dom.Comment;

import java.util.List;

/**
 * Created by Asif on 10/10/2017.
 */

public class CustomCityDetailListAdapter extends RecyclerView.Adapter<CustomCityDetailListAdapter.MyViewHoled> {

    private List<DetailCity> commentList;
    private LayoutInflater layoutInflater;
    private Context context;

    public CustomCityDetailListAdapter(Context context, List<DetailCity> newsList) {
        this.context = context;
        layoutInflater = LayoutInflater.from(context);
        this.commentList = newsList;
    }

    @Override
    public MyViewHoled onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = layoutInflater.inflate(R.layout.item_test, parent, false);
        return new MyViewHoled(view);
    }

    @Override
    public void onBindViewHolder(MyViewHoled holder, int position) {

        if(commentList.get(position).isHeader()){
            holder.textViewTitle.setTypeface(null, Typeface.BOLD);
        } else {
            holder.textViewTitle.setTypeface(null, Typeface.NORMAL);
        }

        holder.textViewTitle.setText(commentList.get(position).getTitle());

    }

    @Override
    public int getItemCount() {
        return commentList.size();
    }

    class MyViewHoled extends RecyclerView.ViewHolder {

        private TextView textViewTitle;

        MyViewHoled(View itemView) {
            super(itemView);
            textViewTitle = itemView.findViewById(R.id.text_item);
        }
    }
}
