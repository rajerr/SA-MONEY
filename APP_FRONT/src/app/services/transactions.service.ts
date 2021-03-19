import { Transaction } from './../model/transaction';
import { map } from 'rxjs/operators';
import { environment } from './../../environments/environment';
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class TransactionsService {

  constructor(private http:HttpClient) { }
  depot(data: object) {
    return this.http.post(`${environment.url}/user/transactions`, data).pipe(map(data=>{
      return data;
    }));
  }
  retrait(data: object) {
    return this.http.post(`${environment.url}/user/transactions`, data).pipe(map(data=>{
      return data;
    }));
  }

  allTransactions(): Observable<any> {
    return this.http.get(`${environment.url}/user/transactions`);
  }

  getTransactionByCodeTrans($code: any){
    return this.http.put(`${environment.url}/user/transactions/code`, $code);
  }

  getTransactionByUser(){
    return this.http.get<Transaction[]>(`${environment.url}/user/transactions/useragence`).pipe(map(data=>{
      // console.log(data);
      return data;
    }));
  }

  getTransactionByAgence(){
    return this.http.get<Transaction[]>(`${environment.url}/user/transactions/agence`).pipe(map(data=>{
      // console.log(data);
      return data;
    }));
  }
  bloquerTransaction($code: any){
    return this.http.put(`${environment.url}/user/transactions/annuler`, $code);
  }
}
