import { AuthService } from './../services/auth.service';
import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor
} from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable()
export class AuthInterceptor implements HttpInterceptor {

  constructor(private authService: AuthService) {}

  intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {

    if (this.authService.isLogin()) {
      const authToken = this.authService.getAuthorizationToken();
      request = request.clone({
          headers: request.headers.set('Authorization', 'Bearer ' + authToken)
      });
    }
    return next.handle(request);
  }
}
