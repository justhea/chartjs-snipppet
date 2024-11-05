Route::get('/dashboard-pass-and-failed', [dashboardController::class, 'dashboardPassAndFailed'])->name('dashboard-pass-and-failed')->middleware('api');
Route::get('/dashboard-grades-difference', [dashboardController::class, 'dashboardGradesDifference'])->name('dashboard-grades-difference')->middleware('api');
Route::get('/dashboard-grades-average', [dashboardController::class, 'dashboardGradesAverage'])->name('dashboard-grades-average')->middleware('api');
Route::get('/dashboard-section-count', [dashboardController::class, 'dashboardSectionCount'])->name('dashboard-section-count')->middleware('api');
Route::get('/dashboard-section-passing', [dashboardController::class, 'dashboardSectionPassing'])->name('dashboard-section-passing')->middleware('api');