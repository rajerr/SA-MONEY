import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: 'home',
    loadChildren: () => import('./home/home.module').then( m => m.HomePageModule)
  },
  {
    path: '',
    redirectTo: 'home',
    pathMatch: 'full'
  },
  {
    path: 'login',
    loadChildren: () => import('./login/login.module').then( m => m.LoginPageModule)
  },
  {
    path: 'admin',
    loadChildren: () => import('./admin/admin.module').then( m => m.AdminPageModule)
  },
  {
    path: 'user',
    loadChildren: () => import('./user/user.module').then( m => m.UserPageModule)
  },
  {
    path: 'menu-admin',
    loadChildren: () => import('./menu-admin/menu-admin.module').then( m => m.MenuAdminPageModule)
  },
  {
    path: 'menu-user',
    loadChildren: () => import('./menu-user/menu-user.module').then( m => m.MenuUserPageModule)
  },
  {
    path: 'depot',
    loadChildren: () => import('./depot/depot.module').then( m => m.DepotPageModule)
  },
  {
    path: 'retrait',
    loadChildren: () => import('./retrait/retrait.module').then( m => m.RetraitPageModule)
  },
  {
    path: 'header',
    loadChildren: () => import('./header/header.module').then( m => m.HeaderPageModule)
  },
  {
    path: 'show-string',
    loadChildren: () => import('./show-string/show-string.module').then( m => m.ShowStringPageModule)
  },
  {
    path: 'calculateur',
    loadChildren: () => import('./calculateur/calculateur.module').then( m => m.CalculateurPageModule)
  },
  {
    path: 'transactions-admin',
    loadChildren: () => import('./transactions-admin/transactions-admin.module').then( m => m.TransactionsAdminPageModule)
  },
  {
    path: 'transactions-user',
    loadChildren: () => import('./transactions-user/transactions-user.module').then( m => m.TransactionsUserPageModule)
  },
  {
    path: 'commissions',
    loadChildren: () => import('./commissions/commissions.module').then( m => m.CommissionsPageModule)
  },
  {
    path: 'calculateur-user',
    loadChildren: () => import('./calculateur-user/calculateur-user.module').then( m => m.CalculateurUserPageModule)
  },
  {
    path: 'bloquer-transaction',
    loadChildren: () => import('./bloquer-transaction/bloquer-transaction.module').then( m => m.BloquerTransactionPageModule)
  }
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
