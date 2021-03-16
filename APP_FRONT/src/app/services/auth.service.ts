import { environment } from './../../environments/environment';
import { Injectable } from '@angular/core';
import { HttpClient } from  '@angular/common/http';
import { from, Observable } from  'rxjs';
import { JwtHelperService } from '@auth0/angular-jwt';
import { map } from 'rxjs/operators';
// import { Storage } from  '@ionic/storage';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  helper = new JwtHelperService();
  constructor(private http: HttpClient) { }


  // tslint:disable-next-line: typedef
  login(data: any) {
    return this.http.post(`${environment.url}/login_check`, data).pipe(map(token =>{
      localStorage.setItem("currentUser", JSON.stringify(token));
      return token;
    }))
  }2

  allUsers(): Observable<any> {
    return this.http.get(`${environment.url}/user/users`);
  }


  // tslint:disable-next-line: typedef
  isLogin() {
    if (localStorage.getItem('currentUser')) {
      return true;
    }
    return false;
  }

  // tslint:disable-next-line: typedef
  getAuthorizationToken() {
    // tslint:disable-next-line: no-non-null-assertion
    const currentUser = JSON.parse(localStorage.getItem('currentUser')!);
    // console.log(currentUser);
    return currentUser.token;
  }

  isLoggedIn(): boolean {
    // tslint:disable-next-line: no-non-null-assertion
    const token = localStorage.getItem('token')!;
    return !this.helper.isTokenExpired(token);
  }

  // tslint:disable-next-line: typedef
  logout(){
    localStorage.removeItem('token');
  }
}
