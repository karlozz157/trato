<?php
namespace Prexto\Controller;

use Prexto\Manager\ContractManager;

class ContractController
{
    /**
     * @param $request
     * @param $response
     * @param $args
     *
     * @return $response
     */
    public function index($request, $response, $args)
    {
        try {
            $manager = new ContractManager($args['contractId']);

            $data = [];
            $data['variables'] = $manager->getVariables();

            return $response->withJson(['status' => 'ok', 'data' => $data]);

        } catch (\Exception $ex) {
            return $response->withJson(['status' => 'error', 'message' => $ex->getMessage()]);
        }
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     *
     * @return $response
     */
    public function post($request, $response, $args)
    {
        try {
            $post = $request->getParsedBody();

            $config       = isset($post['config']) ? $post['config'] : [];
            $variables    = isset($post['variables']) ? $post['variables'] : [];
            $participants = isset($post['participants']) ? $post['participants'] : [];

            $manager = new ContractManager($args['contractId']);
            $manager->configurate($config);

            foreach ($variables as $participantId => $vars) {
                $manager->setVariables($participantId, $vars);
            }

            foreach ($participants as $participantId => $participant) {
                $manager->setParticipant($participantId, $participant);
            }

            $manager->toSign();

            return $response->withJson(['status' => 'ok', 'data' => []]);

        } catch (\Exception $ex) {
            return $response->withJson(['status' => 'error', 'message' => $ex->getMessage()]);
        }
    }
}
