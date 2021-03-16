import { AuthService } from './../services/auth.service';
import { Component, ContentChild, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { IonInput } from '@ionic/angular';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {
  helper = new JwtHelperService();
  LoginForm: FormGroup | any;
  username: string | any;
  password: string | any;
  role: string | any;
  showPassword = false;
  @ContentChild(IonInput) input: IonInput;
  constructor(
    private authService: AuthService ,
    private formBuilder: FormBuilder,
    private router: Router) 
    { }
    
  toggleShow() {
    this.showPassword = !this.showPassword;
    this.input.value = this.showPassword ? '' : '';
  }

  ngOnInit(): void {
    this.LoginForm = this.formBuilder.group({
      username: ['', Validators.required],
      password: ['', Validators.required],
    });
  }

  onLogin(): void {
    if (this.LoginForm.invalid){
      return;
    }
    this.authService.login(this.LoginForm.value)
      .subscribe(
        (res) => {
          console.log(res);
          const helper = new JwtHelperService();
          const decodeToken = helper.decodeToken(Object.values(res)[0]);
          console.log(decodeToken.roles[0]);
          console.log(decodeToken);

          // tslint:disable-next-line: triple-equals
          if (decodeToken.roles[0] == 'ROLE_ADMINAGENCE'){
            this.router.navigateByUrl('/admin');
          }
          // tslint:disable-next-line: triple-equals
          if (decodeToken.roles[0] == 'ROLE_USERAGENCE'){
            this.router.navigateByUrl('/user');
          }
        },
        (err) => {
          console.log(err);
          this.router.navigateByUrl('login');
      }
    );
  }
}
