package com.esgi.cityfinder;

import android.app.ActivityOptions;
import android.content.Intent;
import android.os.Build;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v4.app.ActivityOptionsCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.CardView;
import android.transition.Explode;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.esgi.cityfinder.Model.Auth;
import com.esgi.cityfinder.Network.IServiceResultListener;
import com.esgi.cityfinder.Network.RetrofitAuthService;
import com.esgi.cityfinder.Network.ServiceResult;

import java.util.HashMap;

import butterknife.ButterKnife;
import butterknife.InjectView;
import butterknife.OnClick;

public class LoginActivity extends AppCompatActivity {

    @InjectView(R.id.et_username)
    EditText etUsername;
    @InjectView(R.id.et_password)
    EditText etPassword;
    @InjectView(R.id.bt_go)
    Button btGo;
    @InjectView(R.id.cv)
    CardView cv;
    @InjectView(R.id.fab)
    FloatingActionButton fab;

    private RetrofitAuthService authService;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        ButterKnife.inject(this);
    }

    @OnClick({R.id.bt_go, R.id.fab, R.id.tv_guest})
    public void onClick(View view){
        switch (view.getId()) {
            case R.id.fab:
                getWindow().setExitTransition(null);
                getWindow().setEnterTransition(null);

                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
                    ActivityOptions options =
                            ActivityOptions.makeSceneTransitionAnimation(this, fab, fab.getTransitionName());
                    startActivity(new Intent(this, RegisterActivity.class), options.toBundle());
                } else {
                    startActivity(new Intent(this, RegisterActivity.class));
                }
                break;
            case R.id.bt_go:
                checkAuth();
                break;
            
            case R.id.tv_guest:

                // TODO: 07/10/2017
                
                break;
            
        }
    }

    private void checkAuth(){

        String email = etUsername.getText().toString();
        String password = etPassword.getText().toString();

        if(email.isEmpty()){
            etUsername.setError("Champ vide");
            return;
        }

        if(password.isEmpty()){
            etPassword.setError("Champ vide");
            return;
        }

        HashMap<String,String> userMap = new HashMap<>();
        userMap.put("email",email);
        userMap.put("password",password);

        getAuthService().authentication(userMap, new IServiceResultListener<Auth>() {
            @Override
            public void onResult(ServiceResult<Auth> result) {

                Auth auth = result.getData();

                if(auth != null){
                    Toast.makeText(getBaseContext(),"Connexion réussi",Toast.LENGTH_SHORT).show();
                    showSearchActivity(auth);
                } else {
                    Toast.makeText(getBaseContext(),result.getErrorMsg(),Toast.LENGTH_SHORT).show();
                }
            }
        });
    }

    private void showSearchActivity(Auth auth){
        Explode explode = new Explode();
        explode.setDuration(500);

        getWindow().setExitTransition(explode);
        getWindow().setEnterTransition(explode);
        ActivityOptionsCompat oc2 = ActivityOptionsCompat.makeSceneTransitionAnimation(this);
        Intent i2 = new Intent(this,SearchActivity.class);
        i2.putExtra("auth",auth);
        startActivity(i2, oc2.toBundle());
    }

    private RetrofitAuthService getAuthService(){
        if(authService == null){
            authService = new RetrofitAuthService();
        }
        return authService;
    }
}
