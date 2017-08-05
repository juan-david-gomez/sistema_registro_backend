<?php

$app->group('/registro/', function () {
    
    $modelEntity = 'App\Model\Registro';

    $this->get('', function ($req, $res, $args) use ($modelEntity){
        ApiRenderer::jsonResponse($res,200,$modelEntity::all()->toJson());
    });
     
    $this->get('{id}',  function($req, $res, $args) use ($modelEntity){
        try {
            ApiRenderer::jsonResponse($res,200,$modelEntity::findOrFail($args['id'])->toJson());
        } catch (Exception $e) {
            $error['text'] = 'Unable to get the web service. ';
            $error['message'] = $e->getMessage();
            ApiRenderer::jsonResponse($res,404,$error);
        }
    });
     
    $this->get('search/{query}', function($req, $res, $args) use ($modelEntity){
        ApiRenderer::jsonResponse($res,200,$modelEntity::where('id_evento', '=', $args['query'])->get()->toJson());
    });
     
    $this->post('', function($req, $res,$args) use ($app,$modelEntity) {
        try {
            $model = new $modelEntity;
            $allPostPutVars = $req->getParsedBody();

            $model->id_evento = $allPostPutVars['id_evento'];
            $model->id_persona = $allPostPutVars['id_persona'];
     
            if($model->save()) {
                $result['text'] =  "Successfully add new element";
                $result['obj'] =  $model;
            } else {
                $result['text'] =  'Failed to add new element"}';
            }

            ApiRenderer::jsonResponse($res,200,$result);
        } catch (Exception $e) {
            $error['text'] = 'Unable to get the web service. ';
            $error['message'] = $e->getMessage();
            ApiRenderer::jsonResponse($res,404,$error);
        }
     
    });
     
    $this->put('{id}', function($req, $res,$args) use ($app,$modelEntity) {
        try {
            $model = $modelEntity::findOrFail($args['id']);
            $allPostPutVars = $req->getParsedBody();

            $model->id_evento = $allPostPutVars['id_evento'];
            $model->id_persona = $allPostPutVars['id_persona'];
     
            if($model->save()) {
                $result['text'] =  "Successfully update new element";
                $result['obj'] =  $model;
            } else {
                $result['text'] =  'Failed to update new element"}';
            }

            ApiRenderer::jsonResponse($res,200,$result); 
        } catch (Exception $e) {
            $error['text'] = 'Unable to get the web service. ';
            $error['message'] = $e->getMessage();
            ApiRenderer::jsonResponse($res,404,$error);
        }
         
    });
     
    $this->delete('{id}', function($req, $res,$args) use ($modelEntity){
        $model = $modelEntity::findOrFail($args['id']);
         
        if($model->delete()) {
            $result['text'] =  "Successfully delete new element";
        } else {
            $result['text'] =  'Failed to delete new element"}';
        }

        ApiRenderer::jsonResponse($res,200,$result); 
    });
    
});