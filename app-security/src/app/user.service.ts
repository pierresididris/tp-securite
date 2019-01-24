import { Injectable } from '@angular/core';
import { HttpClient, HttpClientModule, HttpHeaders } from '@angular/common/http';
import { User } from './user';
import { Observable, of, Subscription, Subject } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';

const baseUrl : string = "http://localhost/dev/a3/tp-securite/rest/index.php?" ;
const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type': 'application/json',
  })
};

@Injectable({
  providedIn: 'root',
})

export class UserService {
  connectedUser: User;

  constructor(
    private http: HttpClient,
  ) 
  { 
    this.connectedUser = new User();
  }

  addUser(user : User) : Observable<any> {
    const url = `${baseUrl}add-user`;
    let parameters = {
      "email": user.email,
      "pwd": user.password,
      "profil": user.profilId,
    }
    return this.http.post<User>(url, parameters, httpOptions).pipe(
      tap((user) => console.log(`added user`)),
      map((response) => {
        return response;
      }),
      catchError(this.handleError<User>('add todo'))
    );
  }

  connectUser(user: User): Observable<any>{
    const url = `${baseUrl}connect-user`;
    let parameters = {
      "email": user.email,
      "pwd": user.password,
    }
    return this.http.post<User>(url, parameters, httpOptions).pipe(
      tap((user) => console.log(`connect user`)),
      map((userId) => {
        return userId;
      }),
      catchError(this.handleError<User>('connect user'))
    );
  }

  deconnectUSer(): Observable<any>{
    const url = `${baseUrl}deconnect-user`;
    return this.http.get(url, httpOptions).pipe(
      tap((noParameter) => console.log(`Disconnect User`)),
      map((response) => {
        if(response.hasOwnProperty("sessionDestroy")){
          this.connectedUser = new User();
        }else{
          console.log("something went wrong when trying to disconnect")
        }
        return response;
      }),
      catchError(this.handleError('disconnect user'))
    );
  }

    /**
   * Handle Http operation that failed.
   * Let the app continue.
   * @param operation - name of the operation that failed
   * @param result - optional value to return as the observable result
   */
  private handleError<T> (operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
  
      // TODO: send the error to remote logging infrastructure
      console.error(error); // log to console instead
  
      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }

  checkMail(email): boolean{
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }

  checkPwd(pwd, pwdCheck): boolean{
    var result = false;
    if (pwd === pwdCheck){
        result = true;
    }
    return result;
  }

  checkProfil(profil): boolean{
    var result = false;
    if (profil != "" && profil != 0 ){
        result = true;
    }
    return result;
  }
}
