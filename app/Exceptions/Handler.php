<?php namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if ($this->isHttpException($e))
		{
			return $this->renderHttpException($e);
		}
		else
		{
            // If the user attempts to access a record that is not permissible or does not
            // exist we will need to send them back to the homepage.
            //
            if ( $e instanceof ModelNotFoundException )
            {
                $nonExistentMessage = 'The page you attempted to access does not exist or has been removed.';

                // Return json response if
                if ( $request->ajax() )
                {
                    return response()->make(['error' => 404, 'message' => $nonExistentMessage], 404);
                }

                return response()->make(view('errors.404'), 404);
            }

			return parent::render($request, $e);
		}
	}

}
