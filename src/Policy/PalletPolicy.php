<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Pallet;
use Authorization\Policy\Result;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Cake\Core\Configure;
use Cake\Utility\Text;

/**
 * Pallet policy
 */
class PalletPolicy implements BeforePolicyInterface
{
    /**
     * Check if $user can create Pallet
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Pallet $pallet
     * @return bool
     */
    
    public function before(?IdentityInterface $user, $pallet, $action) {
        return $user->role === 'admin' || $user->is_superuser ? true : null;
    }

    public function canCreate(IdentityInterface $user, Pallet $pallet)
    {
       
    }

    public function canBestBeforeEdit(IdentityInterface $user, Pallet $pallet)
    {
        
        $canBestBeforeEdit = Configure::read('canBestBeforeEdit');
     
        if(in_array($user->username, $canBestBeforeEdit['users'] )) {
            return new Result(true);
        }
        if(in_array($user->role, $canBestBeforeEdit['roles'])) {
            return new Result(true);
        }
        return new Result(false, "You need to be assigned a role of " . Text::toList($canBestBeforeEdit['roles'], 'or') . ' to edit this field');
    }

    /**
     * Check if $user can update Pallet
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Pallet $pallet
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, Pallet $pallet)
    {
      
        return new Result(false);

    }

    /**
     * Check if $user can delete Pallet
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Pallet $pallet
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Pallet $pallet)
    {
    }

    /**
     * Check if $user can view Pallet
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Pallet $pallet
     * @return bool
     */
    public function canView(IdentityInterface $user, Pallet $pallet)
    {
    }
}
