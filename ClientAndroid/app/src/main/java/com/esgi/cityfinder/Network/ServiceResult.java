package com.esgi.cityfinder.Network;

/**
 * Created by Asifadam93 on 03/07/2017.
 */

public class ServiceResult<T> {

    private T data;
    private String errorMsg;

    public ServiceResult() {
        data = null;
        errorMsg = "";
    }

    public ServiceResult(String errorMsg) {
        this.errorMsg = errorMsg;
    }

    public T getData() {
        return data;
    }

    public void setData(T data) {
        this.data = data;
    }

    public String getErrorMsg() {
        return errorMsg;
    }

    public void setErrorMsg(String errorMsg) {
        this.errorMsg = errorMsg;
    }
}
