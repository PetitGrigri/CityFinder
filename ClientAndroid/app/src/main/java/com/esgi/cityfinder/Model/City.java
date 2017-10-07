package com.esgi.cityfinder.Model;

import android.os.Parcel;
import android.os.Parcelable;

/**
 * Created by Asifadam93 on 07/10/2017.
 */

public class City implements Parcelable {

    private String name;
    private String detail;
    private int photoId;

    public City(String name, String detail ,int photoId) {
        this.name = name;
        this.photoId = photoId;
        this.detail = detail;
    }

    protected City(Parcel in) {
        name = in.readString();
        detail = in.readString();
        photoId = in.readInt();
    }

    public static final Creator<City> CREATOR = new Creator<City>() {
        @Override
        public City createFromParcel(Parcel in) {
            return new City(in);
        }

        @Override
        public City[] newArray(int size) {
            return new City[size];
        }
    };

    public String getName() {
        return name;
    }

    public String getDetail() {
        return detail;
    }

    public int getPhotoId() {
        return photoId;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel parcel, int i) {
        parcel.writeString(name);
        parcel.writeString(detail);
        parcel.writeInt(photoId);
    }
}
