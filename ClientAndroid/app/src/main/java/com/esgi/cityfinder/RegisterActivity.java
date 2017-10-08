package com.esgi.cityfinder;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.os.Build;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.CardView;
import android.transition.Transition;
import android.transition.TransitionInflater;
import android.view.View;
import android.view.ViewAnimationUtils;
import android.view.animation.AccelerateInterpolator;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.esgi.cityfinder.Model.Auth;
import com.esgi.cityfinder.Model.User;
import com.esgi.cityfinder.Network.IServiceResultListener;
import com.esgi.cityfinder.Network.RetrofitUserService;
import com.esgi.cityfinder.Network.ServiceResult;

import java.util.HashMap;

import butterknife.ButterKnife;
import butterknife.InjectView;
import butterknife.OnClick;

public class RegisterActivity extends AppCompatActivity {

    @InjectView(R.id.close_fab)
    FloatingActionButton closeFab;
    @InjectView(R.id.bt_go)
    Button buttonNext;
    @InjectView(R.id.cv_add)
    CardView cvAdd;
    @InjectView(R.id.et_username)
    EditText etEmail;
    @InjectView(R.id.et_password)
    EditText etPassword;
    @InjectView(R.id.et_repeatpassword)
    EditText etPasswordRepete;

    private RetrofitUserService userService;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        ButterKnife.inject(this);

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            ShowEnterAnimation();
        }
    }

    @OnClick({R.id.bt_go, R.id.close_fab})
    public void onClick(View view) {
        switch (view.getId()) {

            case R.id.close_fab:
                animateRevealClose();
                break;

            case R.id.bt_go:
                checkRegister();
                break;
        }
    }

    private void checkRegister(){

        String email = etEmail.getText().toString();
        String password = etPassword.getText().toString();
        String passwordRepete = etPasswordRepete.getText().toString();

        if(email.isEmpty()){
            etEmail.setError("Champ vide");
            return;
        }

        if(password.isEmpty()){
            etPassword.setError("Champ vide");
            return;
        }

        if(passwordRepete.isEmpty()){
            etPasswordRepete.setError("Champ vide");
            return;
        }

        if(!password.equalsIgnoreCase(passwordRepete)){
            etPassword.setError("Erreur mot de passe");
            return;
        }

        HashMap<String,String> userMap = new HashMap<>();
        userMap.put("firstName","null");
        userMap.put("lastName","null");
        userMap.put("email",email);
        userMap.put("plainPassword",password);

        getUserService().register(userMap, new IServiceResultListener<User>() {
            @Override
            public void onResult(ServiceResult<User> result) {

                User user = result.getData();

                if(user != null){
                    Toast.makeText(getBaseContext(),"Création de compte réussi",Toast.LENGTH_SHORT).show();
                    RegisterActivity.super.onBackPressed();
                } else {
                    Toast.makeText(getBaseContext(),result.getErrorMsg(),Toast.LENGTH_SHORT).show();
                }
            }
        });
    }


    private void ShowEnterAnimation() {
        Transition transition = TransitionInflater.from(this).inflateTransition(R.transition.fabtransition);
        getWindow().setSharedElementEnterTransition(transition);

        transition.addListener(new Transition.TransitionListener() {
            @Override
            public void onTransitionStart(Transition transition) {
                cvAdd.setVisibility(View.GONE);
            }

            @Override
            public void onTransitionEnd(Transition transition) {
                transition.removeListener(this);
                animateRevealShow();
            }

            @Override
            public void onTransitionCancel(Transition transition) {

            }

            @Override
            public void onTransitionPause(Transition transition) {

            }

            @Override
            public void onTransitionResume(Transition transition) {

            }


        });
    }

    public void animateRevealShow() {
        Animator mAnimator = ViewAnimationUtils.createCircularReveal(cvAdd, cvAdd.getWidth() / 2, 0, closeFab.getWidth() / 2, cvAdd.getHeight());
        mAnimator.setDuration(500);
        mAnimator.setInterpolator(new AccelerateInterpolator());
        mAnimator.addListener(new AnimatorListenerAdapter() {
            @Override
            public void onAnimationEnd(Animator animation) {
                super.onAnimationEnd(animation);
            }

            @Override
            public void onAnimationStart(Animator animation) {
                cvAdd.setVisibility(View.VISIBLE);
                super.onAnimationStart(animation);
            }
        });
        mAnimator.start();
    }

    public void animateRevealClose() {
        Animator mAnimator = ViewAnimationUtils.createCircularReveal(cvAdd, cvAdd.getWidth() / 2, 0, cvAdd.getHeight(), closeFab.getWidth() / 2);
        mAnimator.setDuration(500);
        mAnimator.setInterpolator(new AccelerateInterpolator());
        mAnimator.addListener(new AnimatorListenerAdapter() {
            @Override
            public void onAnimationEnd(Animator animation) {
                cvAdd.setVisibility(View.INVISIBLE);
                super.onAnimationEnd(animation);
                closeFab.setImageResource(R.drawable.plus);
                RegisterActivity.super.onBackPressed();
            }

            @Override
            public void onAnimationStart(Animator animation) {
                super.onAnimationStart(animation);
            }
        });
        mAnimator.start();
    }

    @Override
    public void onBackPressed() {
        animateRevealClose();
    }

    public RetrofitUserService getUserService() {

        if(userService == null){
            userService = new RetrofitUserService();
        }

        return userService;
    }
}
