<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserLoginProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly UserPasswordHasherInterface $userPasswordEncoder
    ) {

    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $user = $this->repository->findOneBy(['email' => $data->getEmail()]);
        if ($user instanceof User && $this->userPasswordEncoder->isPasswordValid($user, $data->getPlainPassword())) {
            return new JsonResponse([
                'token' => $user->getToken()
            ], Response::HTTP_OK, []);
        }

        return new JsonResponse([
            'error' => 'Invalid credentials.'
        ], Response::HTTP_UNAUTHORIZED, []);
    }
}
