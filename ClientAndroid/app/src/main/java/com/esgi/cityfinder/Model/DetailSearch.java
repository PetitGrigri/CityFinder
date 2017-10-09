package com.esgi.cityfinder.Model;

import com.esgi.cityfinder.Model.Centrales.Centrales20Km;
import com.esgi.cityfinder.Model.Centrales.Centrales30Km;
import com.esgi.cityfinder.Model.Centrales.Centrales80Km;
import com.esgi.cityfinder.Model.Hotel.HotelLocatedIn;
import com.esgi.cityfinder.Model.Hotel.HotelsNear;
import com.google.gson.annotations.SerializedName;

import java.util.List;

/**
 * Created by Asif on 09/10/2017.
 */

public class DetailSearch {

    private Integer id;

    @SerializedName("name")
    private String cityName;

    @SerializedName("nomRegion")
    private String regionName;

    @SerializedName("nomDepartement")
    private String departementName;

    @SerializedName("centralesNear80km")
    private List<Centrales80Km> centrales80Km = null;

    @SerializedName("centralesNear30km")
    private List<Centrales30Km> centrales30Km = null;

    @SerializedName("centralesNear20km")
    private List<Centrales20Km> centrales20Km = null;

    @SerializedName("hotelsLocatedIn")
    private List<HotelsNear> hotelsNearList = null;

    @SerializedName("hotelsLocatedIn")
    private List<HotelLocatedIn> hotelLocatedInList = null;

    @SerializedName("museesLocatedIn")
    private List<Musees> museesList = null;

    @SerializedName("museesLocatedIn")
    private List<Poste> posteList = null;

}
