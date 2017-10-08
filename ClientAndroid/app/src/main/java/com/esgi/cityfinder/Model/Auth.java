package com.esgi.cityfinder.Model;

import android.os.Parcel;
import android.os.Parcelable;

import com.google.gson.annotations.SerializedName;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public class Auth implements Parcelable {

    private Integer userId;

    @SerializedName("value")
    private String token;
    private String createdAt;

    protected Auth(Parcel in) {
        token = in.readString();
        createdAt = in.readString();
    }

    public static final Creator<Auth> CREATOR = new Creator<Auth>() {
        @Override
        public Auth createFromParcel(Parcel in) {
            return new Auth(in);
        }

        @Override
        public Auth[] newArray(int size) {
            return new Auth[size];
        }
    };

    public String getToken() {
        return token;
    }

    public String getCreatedAt() {
        return createdAt;
    }

    public Integer getUserId() {
        return userId;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel parcel, int i) {
        parcel.writeString(token);
        parcel.writeString(createdAt);
    }
}
